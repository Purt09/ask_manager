<div class="form-group">
    <h4>Товары: </h4>
    <? $orderProducts = $model->getOrderProducts()->all();
    if(empty($orderProducts)){
        echo 'Товаров нет';
    } else {
        ?>
    <table class="table table-striped table-order-products">
        <thead>
        <tr>
            <th>Название</th>
            <th style="width:150px;">Цена</th>
            <th style="width:100px;">Кол-во</th>
            <th style="width:50px;"></th>
        </tr>
        </thead>
        <tbody>
            <? $i = 1;
            foreach($orderProducts as $orderProduct){ ?>
                <tr class="tr_product<?=$orderProduct->id?>">
                <td><?=$orderProduct->product->name?></td>
                <td>
                    <input type="hidden" class="form-control" name="OrderProductId[]" value="<?=$orderProduct->id;?>">
                    <input onchange="order_calc(<?=$model->id?>)" type="number" class="form-control" style="width:100px;display: inline-block;" name="OrderProductPrice[<?=$orderProduct->id;?>]" value="<?=$orderProduct->price;?>" min="0">
                     р.
                </td>
                <td>
                    <input onchange="order_calc(<?=$model->id?>)" type="number" class="form-control" name="OrderProductCount[<?=$orderProduct->id;?>]" value="<?=$orderProduct->count;?>" min="0">
                </td>
                <td><a class="text-danger js_delete_product" href="/admin/order/delete-product/<?=$orderProduct->id?>" title="Удалить" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
               </td>
               </tr>
            <?  } ?>
        </tbody>
    </table>
    <? } ?>
</div>
