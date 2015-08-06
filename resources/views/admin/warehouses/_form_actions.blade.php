<a class="btn btn-white" href="{{ $warehouse->exists ? '/warehouse/' . $warehouse->id . '/show' : '/warehouses' }}">Cancel</a>
<button class="btn btn-primary save-warehouse-btn" data-loading-text="Saving..." type="button">Save Warehouse</button>
