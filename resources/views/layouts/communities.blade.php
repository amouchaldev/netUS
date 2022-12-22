<div class="list-group">
    <div class="list-group-item list-group-item-action flex-column align-items-start">
          <h5 class="mb-1">Communities you might like</h5>
    </div>
    @foreach($recommendedCommunities as $community)
        <x-community-card 
                :community="$community"
        ></x-community-card>
   @endforeach
</div>