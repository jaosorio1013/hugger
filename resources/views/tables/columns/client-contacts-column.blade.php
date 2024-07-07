<div class="w-full">
    @if($getState() === null)
        <tr>
            <td colspan="5">
                <x-filament-tables::empty-state
                        heading="Sin contactos"
                        icon="heroicon-o-x-mark"
                />
            </td>
        </tr>
    @else
        <table class="filament-table-repeatable w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5 shadow-lg rounded-xl bg-white">
            <thead>
            <tr>
                <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                    Nombre
                </th>

                <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                    Teléfono
                </th>

                <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                    Cargo
                </th>

                <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                    Email
                </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
            @foreach ($getState() as $contact)
                <tr>
                    <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                        {{ $contact->name }}
                    </td>

                    <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                        {{ $contact->phone }}
                    </td>

                    <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                        {{ $contact->charge }}
                    </td>

                    <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                        {{ $contact->email }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
