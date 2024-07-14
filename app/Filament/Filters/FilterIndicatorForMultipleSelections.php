<?php

namespace App\Filament\Filters;

use Illuminate\Support\Collection;

trait FilterIndicatorForMultipleSelections
{
    private function filterIndicatorForMultipleSelection(array $data, array &$indicators, Collection $options, string $field, string $fieldLabel): void
    {
        if ($data[$field] ?? null) {
            $labels = $options
                ->mapWithKeys(fn(string|array $label, string $value): array => is_array($label) ? $label : [$value => $label])
                ->only($data[$field])
                ->all();

            $indicators[$field] = $fieldLabel . ': ' . collect($labels)->join(', ', ' o ');;
        }
    }
}