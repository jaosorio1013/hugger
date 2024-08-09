@if($client->address !== null)
    <div>
        <i class="fa-solid fa-location-dot pr-2 text-gray-400"></i>
        {{ $client->address }}
    </div>
@endif

@if($client->location_city_id !== null)
    <div>
        <i class="fa-solid fa-city pr-2 text-gray-400"></i>
        {{ $client->city->name }}
    </div>
@endif

@if($client->email !== null)
    <div>
        <i class="fa-solid fa-envelope pr-2 text-gray-400"></i>
        {{ $client->email }}
    </div>
@endif

@if($client->phone !== null)
    <div>
        <i class="fa-solid fa-phone pr-2 text-gray-400"></i>
        {{ $client->phone }}
    </div>
@endif

@if($client->nit !== null)
    <div>
        <i class="fa-solid fa-address-card pr-2 text-gray-400"></i>
        {{ $client->nit }}
    </div>
@endif
