<x-app-layout>
    <div class="container-fluid">
        <div class="row">
            @foreach ($statuses as $status)
            <div class="col-md-3 col-sm-6">
                <h3>{{ ucfirst($status->name) }}</h3>
                <div class="card-body rounded">
                    <div class="row">
                        <ul class="{{ $status->name }}-list sortable ui-sortable pt-1" id="sort-{{ $status->name }}"
                            data-status-id="{{ $status->id }}">
                            @foreach ($items as $item)
                            @if ($status->id === $item->status_id)
                            <li class="list-item card mb-3 p-2" data-task-id="{{ $item->id }}"
                                data-color-id="{{ $item->color->id }}"
                                style="background-color:{{ $item->color->color }} !important">
                                {{ $item->desc }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        <div class="add-new-button border add-new" data-status-name="{{ $status->name }}">
                            <button class="col-md-12 p-5 mx-auto">+ Add New Card
                            </button>
                        </div>
                        <div class="task-input border pt-0 mt-4 hidden" id="{{ $status->name }}">
                            <textarea type="textarea" class="form-control" rows="3"></textarea>
                            <button class="btn task-add" data-status-id="{{ $status->id }}">Add Card</button>
                            <button class="btn cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Modal Start -->
            <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalTitle">The title for this card would be here</h5>
                            <button type="button" class="update" aria-label="Update">
                                <span aria-hidden="true"><img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ asset('/assets/img/check-circle.svg') }}" /></span>
                            </button>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ asset('/assets/img/cross-circle.svg') }}" /></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <h5 class="">Description</h5>
                                <textarea type="textarea" class="form-control" rows="3"></textarea>
                            </div>
                            <div class='mt-2'>
                                <h5 class="">Color</h5>
                                @foreach ($colors as $color)
                                <div class="color-palette inline-block p-3" id="color-palette-{{ $color->id }}"
                                    data-color-id="{{ $color->id }}" style="background: {{ $color->color }} 0% 0% no-repeat padding-box; border: 1px solid
                                    #00000066; border-radius: 10px; opacity: 1;"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End -->
        </div>
    </div>



    <div class=" py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
            </div>
        </div>
    </div>

</x-app-layout>