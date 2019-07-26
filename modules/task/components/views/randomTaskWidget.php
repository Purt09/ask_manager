

<button type="button" class="btn-default btn btn-block" data-toggle="modal" data-target="#RandomTask">случайная задача
</button>


<!-- Modal -->
<div class="modal fade" id="RandomTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center" id="myModalLabel"> <?= $task->title ?></h4>
            </div>
        </div>
    </div>
</div>