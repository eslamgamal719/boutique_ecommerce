    <tr>     <!-- no need to div because these are rows at table -->
        <th class="pl-0 border-0" scope="row">
            <div class="media align-items-center">
            <a class="reset-anchor d-block animsition-link" href="{{ route('frontend.product', $item->model->slug) }}">
                <img src="{{ asset('assets/products/' . $item->model->firstMedia->file_name) }}" alt="{{ $item->name }}" width="70"/>
            </a>
            <div class="media-body ml-3">
                <strong class="h6">
                <a class="reset-anchor animsition-link" href="{{ route('frontend.product', $item->model->slug) }}">
                    {{ $item->name }}</a>
                </strong>
            </div>
            </div>
        </th>     
        <td class="align-middle border-0">
            <p class="mb-0 small">${{ $item->price }}</p>
        </td>
        <td class="align-middle border-0">
            <div class="border d-flex align-items-center justify-content-between px-3">
            <span class="small text-uppercase text-gray headings-font-family">Quantity</span>
            <div class="quantity">
                <button wire:click="decreaseQuantity('{{ $item->rowId }}')" class="p-0"><i class="fas fa-caret-left"></i></button>
                <span class="form-control form-control-sm border-0 shadow-0 px-2 text-center">
                    {{ $item_quantity }}
                </span>
                <!-- <input class="form-control form-control-sm border-0 shadow-0 p-0" type="text" value="{{ $item->qty }}"/> -->
                <button wire:click="increaseQuantity('{{ $item->rowId }}')" class="p-0"><i class="fas fa-caret-right"></i></button>
            </div>
            </div>
        </td>
        <td class="align-middle border-0">
            <p class="mb-0 small">${{ $item->qty * $item->price }}</p>
        </td>
        <td class="align-middle border-0">
            <a class="reset-anchor" href="#"><i class="fas fa-trash-alt small text-muted"></i></a>
        </td>
    </tr>

