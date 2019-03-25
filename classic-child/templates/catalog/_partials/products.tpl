{extends file="parent:catalog/_partials/products.tpl"}


<div id="js-product-list">
  <div class="products row">
    {foreach from=$listing.products item="product"}
      {block name='product_miniature'}
        {include file='catalog/_partials/miniatures/product.tpl' product=$product}
      {/block}
    {/foreach}
  </div>

 {block name='pagination'}
  {/block}