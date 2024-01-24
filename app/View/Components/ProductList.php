<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductList extends Component
{
    /**
     * Create a new component instance.
     */
//    public string $name;
//    public int $price;
//    public string $description;
//    public string $slug;
//    public int $teg_id;
//    public int $brand_id;

    public function __construct(
        $id,
        $name,
        $price,
        $description,
//        $teg_id,
//        $brand_id,
        $slug
    )
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
//        $this->teg_id = $teg_id;
//        $this->brand_id = $brand_id;
        $this->slug = $slug;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-list');
    }
}
