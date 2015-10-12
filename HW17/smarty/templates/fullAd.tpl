<div>
    <div class='col-md-offset-3'><h2 class="title sub-header">Объявление № {$full_ad.ad_id}</h2></div>
    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Название:
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <p>{$full_ad.ad_title}</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Цена: 
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <p>{$full_ad.price} руб.</p>
            </div>
        </div>
        </div>

        <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
                    Продавец: 
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <p>{$full_ad.user_name}({$full_ad.type_name})</p>
            </div>
        </div>
        </div>

        <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingFour">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
                    Контактные данные: 
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
            <div class="panel-body">
                <div class='col-md-offset-2'>
                    <p><a href="#"  class="btn btn-default" id="phone"><i class="glyphicon glyphicon-earphone"></i>&nbsp;Показать телефон</a> 
                    <a href="#"  class="btn btn-default" id="email"><i class="glyphicon glyphicon-envelope"></i>&nbsp;Показать Email</a></p>     
                </div>
            </div>
        </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFive">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseTwo">
                        Город: 
                    </a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                <div class="panel-body">
                    <p>{$full_ad.city_name}</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingSix">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseTwo">
                        Категория: 
                    </a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                <div class="panel-body">
                    <p>{$full_ad.category_name}</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingSeven">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseTwo">
                        Описание: 
                    </a>
                </h4>
            </div>
            <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                <div class="panel-body" id="description" >
                    <p>{$full_ad.ad_description}</p>
                </div>
            </div>
        </div>
        <br>
        <div class="col-sm-offset-3 col-sm-9">
            <a id="reset-ad" class="btn btn-primary btn-lg">Назад на главную</a>
        </div>        
    </div>
</div>