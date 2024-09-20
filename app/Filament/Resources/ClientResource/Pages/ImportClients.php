<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Models\Client;
use App\Models\CrmFont;
use App\Models\CrmMean;
use App\Models\Deal;
use App\Models\User;
use Jaosorio1013\FilamentImport\Actions\ImportAction;
use Jaosorio1013\FilamentImport\Actions\ImportField;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;

trait ImportClients
{
    private $client;

    public function importClientAction(): ImportAction
    {
        $fonts = CrmFont::pluck('name', 'id');
        $users = User::whereNotIn('email', [
            'test@example.com',
            'jaosorio1013@gmail.com',
        ])->pluck('name', 'id');

        return ImportAction::make('Importar')
            ->exampleFile('template-clientes')
            ->icon('heroicon-s-document-arrow-up')
            ->massCreate(false)
            ->fields([
                ImportField::make('Identificación'),

                ImportField::make('Nombre')
                    // ->rules(['required'], ['Nombre Requerido'])
                    ->required(),

                ImportField::make('Teléfono'),

                ImportField::make('Email')->rules('email'),
                ImportField::make('Dirección'),

                ImportField::make('Ciudad'),

                ImportField::make('Responsable')
                    ->helperText('(' . $users->implode(', ') . ')'),

                ImportField::make('Fuente')
                    ->helperText('(' . $fonts->implode(', ') . ')'),

                ImportField::make('Tipo')
                    ->helperText('(Natural, Empresa, Aliado)')
                    ->rules('in:Natural,Empresa,Aliado'),

                ImportField::make('Nombres Contactos Cliente'),
                ImportField::make('Teléfonos Contactos Cliente'),
                ImportField::make('Emails Contactos Cliente')->rules('email'),
                ImportField::make('Cargos Contactos Cliente'),

            ], columns: 3)
            ->handleRecordCreation(
        function (array $data): Client {
            $this->createClient($data);

            $this->createClientContact($data);

            return new Client();
        }
    )
        ->after(
            fn(Deal $deal) => redirect(ListClients::getUrl())
        );
    }

    private function createClient(array $data): void
    {
        $nit = $data['Identificación'] ?? null;
        if (null === $nit) {
            return;
        }

        $client = Client::where('nit', $nit)->first();
        if ($client) {
            return;
        }

        $this->client = Client::create([
            'nit' => $nit,
            'name' => $data['Nombre'],
            'phone' => $data['Teléfono'] ?? null,
            'email' => $data['Email'] ?? null,
            'address' => $data['Dirección'] ?? null,
            'location_city_id' => $this->getCity($data['Ciudad'] ?? null),
            'user_id' => $this->getOwner($data['Responsable'] ?? null),
            'crm_font_id' => $this->getFont($data['Fuente'] ?? null),
            'type' => $this->getClientType(
                $data['Tipo'] ?? null
            ),
        ]);
    }

    private function getCity($ciudad)
    {
        $colombiaId = Country::query()
            ->where('name', 'Colombia')
            ->value('id');

        return City::query()
            ->where('country_id', $colombiaId)
            ->where('name', $ciudad)->value('id') ?? null;
    }

    private function getOwner($user)
    {
        return User::where('name', $user)->value('id') ?? null;
    }

    private function getFont(string $font = null)
    {
        return CrmFont::where('name', $font)->value('id') ?? null;
    }

    private function getClientType(string $type = null): int
    {
        $type = trim($type);
        if ('Empresa' === $type) {
            return Client::TYPE_COMPANY;
        }

        if ('Aliado' === $type) {
            return Client::TYPE_ALLIED;
        }

        return Client::TYPE_NATURAL;
    }

    private function createClientContact(array $data): void
    {
        if (empty($data['Nombres Contactos Cliente'])) {
            return;
        }

        $contact = $this->client->contacts()->firstOrCreate([
            'name' => $data['Nombres Contactos Cliente'],
        ]);

        if (!$contact->wasRecentlyCreated) {
            return;
        }

        $contact->update([
            'phone' => $data['Teléfonos Contactos Cliente'] ?? null,
            'email' => $data['Emails Contactos Cliente'] ?? null,
            'charge' => $data['Cargos Contactos Cliente'] ?? null,
        ]);
    }
}
