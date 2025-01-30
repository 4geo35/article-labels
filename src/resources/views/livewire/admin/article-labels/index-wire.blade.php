<div>
     <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x" wire:click="showList">
         <x-al::ico.new-label />
         <span class="hidden lg:inline-block pl-btn-ico-text">Метки</span>
     </button>

    @include("al::admin.article-labels.includes.modals")
</div>
