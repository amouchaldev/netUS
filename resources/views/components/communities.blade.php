<div class="list-group">
    <div class="list-group-item list-group-item-action flex-column align-items-start">
          <h5 class="mb-1">Communities you might like</h5>
    </div>
    @foreach($communities as $community)
        <x-community-card 
                :community="$community"
                    {{-- :name="$community->name" 
                    :description="$community->description" 
                    :slug="$community->slug"
                    :followers="$community->users_count" --}}
        ></x-community-card>
   @endforeach
</div>