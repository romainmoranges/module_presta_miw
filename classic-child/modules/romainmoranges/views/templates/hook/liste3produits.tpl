salut :) je suis overwrite
<ul>
 {foreach from=$products item=product}
 <li>{$product.id_product} {$product.price}€</li>
 {/foreach}
</ul>