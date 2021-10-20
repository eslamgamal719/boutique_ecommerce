<div>
<section class="py-5">
    <div class="container p-0">
    <div class="row">
        <!-- SHOP SIDEBAR-->
        <div class="col-lg-3 order-2 order-lg-1">
       
        <h5 class="text-uppercase mb-4">Categories</h5>
        @forelse ($shop_categories_main as $category_main)
            <div class="py-2 px-4 bg-dark text-white mb-3">
                <strong class="small text-uppercase font-weight-bold">{{ $category_main->name }}</strong>
            </div>
            <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                @forelse ($shop_categories_sub as $category_sub)
                    @if($category_sub->parent_id == $category_main->id)
                        <li class="mb-2">
                            <a class="reset-anchor" href="{{ route('frontend.shop', $category_sub->slug) }}">
                            {{ $category_sub->name }}</a>
                        </li>
                    @endif    
                @empty
                @endforelse
            </ul>
        @empty
        @endforelse

        <h5 class="text-uppercase mb-4">Tags</h5>
            <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                @forelse ($shop_tags_menu as $shop_tag)
                    <li class="mb-2">
                        <a class="reset-anchor" href="{{ route('frontend.shop.tag', $shop_tag->slug) }}">
                        {{ $shop_tag->name }}</a>
                    </li>
                @empty
                @endforelse
            </ul>
        </div>

        
        <!-- SHOP LISTING-->
        <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 mb-2 mb-lg-0">
            <p class="text-small text-muted mb-0">
                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</p>
            </div>
            <div class="col-lg-6">
            <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                <li class="list-inline-item text-muted mr-3">
                    <a class="reset-anchor p-0" href="javascript:void(0);" id="two_items">
                    <i class="fas fa-th-large"></i></a>
                </li>
                <li class="list-inline-item text-muted mr-3">
                    <a class="reset-anchor p-0" href="javascript:void(0);" id="three_items">
                    <i class="fas fa-th"></i></a>
                </li>
                <li wire:ignore class="list-inline-item">
                <select wire:model="sortingBy" class="selectpicker ml-auto" data-width="200"
                 data-style="bs-select-form-control" data-title="Default sorting">
                    <option value="default">Default sorting</option>
                    <option value="popularity">Popularity</option>
                    <option value="low-high">Price: Low to High</option>
                    <option value="high-low">Price: High to Low</option>
                </select>
                </li>
            </ul>
            </div>
        </div>

        <div class="row">

            @forelse ($products as $product)
            <!-- PRODUCT-->
            <div class="col-4" id="products-container-area">
                <div class="product text-center">
                    <div class="mb-3 position-relative">
                        <div class="badge text-white badge-"></div>
                        <a class="d-block" href="{{ route('frontend.product', $product->slug) }}">
                            <img class="img-fluid w-100" src="{{ asset('assets/products/' . $product->firstMedia->file_name) }}"
                             alt="{{ $product->name }}">
                        </a>
                        <div class="product-overlay">
                            <ul class="mb-0 list-inline">
                                <li class="list-inline-item m-0 p-0">
                                    <a wire:click.prevent="addToWishlist('{{ $product->id }}')" class="btn btn-sm btn-outline-dark" href="javascript:void(0);">
                                        <i class="far fa-heart"></i></a>
                                </li>
                                <li class="list-inline-item m-0 p-0">
                                    <a wire:click.prevent="addToCart('{{ $product->id }}')" class="btn btn-sm btn-dark" href="javascript:void(0);">Add to cart</a>
                                </li>
                                <li class="list-inline-item mr-0">
                                    <a wire:click.prevent="$emit('showProductModalAction', '{{ $product->slug }}')" class="btn btn-sm btn-outline-dark" data-target="#productView" data-toggle="modal">
                                        <i class="fas fa-expand"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h6> <a class="reset-anchor" href="{{ route('frontend.product', $product->slug) }}">
                        {{ $product->name }}</a></h6>
                    <p class="small text-muted">${{ $product->price }}</p>
                </div>
            </div>
            @empty
            @endforelse

        </div>

        {!! $products->appends(request()->all())->onEachSide(1)->links() !!}

        <!-- PAGINATION-->
        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center justify-content-lg-end">
            <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
            </ul>
        </nav> -->
        </div>
    </div>
    </div>
</section>
</div>

@push('scripts')
    <script>
        let product_blocks = document.querySelectorAll('#products-container-area');

        document.getElementById('three_items').onclick = function() {
            Array.prototype.forEach.call(product_blocks, function(product_block) {
                if(product_block.classList.contains('col-6')) {
                    product_block.classList.remove('col-6');
                    product_block.classList.add('col-4');
                }
            });
        }

        document.getElementById('two_items').onclick = function() {
            Array.prototype.forEach.call(product_blocks, function(product_block) {
                if(product_block.classList.contains('col-4')) {
                    product_block.classList.remove('col-4');
                    product_block.classList.add('col-6');
                }
            });
        }
    </script>
@endpush