<div class="col-xl-2 col-lg-2 col-6">


{{--    <input type="hidden" name="id" id="id" value="{{$id}}">--}}
    <input type="hidden" name="slug" id="slug" value="{{$slug}}">
    <div class="product-box">
        <div class="img-wrapper">
            <a href="product/details.html">
                <img src="assets/images/fashion/product/front/10.jpg"
                     class="w-100 bg-img blur-up lazyload" alt="">
            </a>
            <div class="circle-shape"></div>
            <span class="background-text">Furniture</span>
            <div class="label-block">
                <span class="label label-theme">30% Off</span>
            </div>
            <div class="cart-wrap">
                <ul>
                    <li>
                        <a class="addtocart-btn">
                            <i data-feather="shopping-cart"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i data-feather="eye"></i>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="wishlist">
                            <i data-feather="heart"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="product-style-3 product-style-chair">
            <div class="product-title d-block mb-0">
                <div class="r-price">
                    <div class="theme-color">{{$price}} ₽</div>
{{--                    <div class="main-price">--}}
{{--                        <ul class="rating mb-1 mt-0">--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-star theme-color"></i>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-star theme-color"></i>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-star"></i>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-star"></i>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <i class="fas fa-star"></i>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </div>
                <p class="font-light mb-sm-2 mb-0">{{$name}}</p>
                <a href="product/details.html" class="font-default">
                    <h5>{{$description}}</h5>
                </a>
            </div>
        </div>
    </div>
</div>

<script>

///var slugString =//
   /// function addToCart(){

   // }

    $('.addtocart-btn').on('click',function(){
        console.log($('#slug').val())
        console.log(slugString)
    })
</script>
