<!-- Block mymodule -->
<div id="mymodule_block_home" class="block">
  <h4>Inspiration</h4>
  <div class="block_content">
    <p>Have a look at som inspiration,

       {if isset($my_module_name) && $my_module_name}
           <!--{$my_module_name}-->
       {else}
          <!-- World-->
       {/if}

    </p>
    <ul>
      <li><a href="{$my_module_link}" title="Click this link">Here!</a></li>
    </ul>
  </div>
</div>
<!-- /Block mymodule -->