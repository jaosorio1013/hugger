<div class="w-full">
    <table class="filament-table-repeatable w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5 shadow-lg rounded-xl bg-white">
        <thead>
        <tr>
            <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                Producto
            </th>

            <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                Cantidad
            </th>

            <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                Precio
            </th>

            <th class="it-table-repeateable-header-cell font-semibold text-gray-950 dark:text-white text-start px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                Total
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
        @foreach ($getState() as $detal)
            <tr>
                <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                    {{ $detal->product->name }}
                </td>

                <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                    {{ $detal->quantity }}
                </td>

                <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                    {{ $detal->price }}
                </td>

                <td class="it-table-repeateable-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 py-2">
                    {{ $detal->total }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
