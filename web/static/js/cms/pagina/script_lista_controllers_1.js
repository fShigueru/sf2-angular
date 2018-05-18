'use strict';
var appPaginaControllers = angular.module('adminControllers', []);

appPaginaControllers.controller('NewCtrl', ['$scope','slugService','getService','postService','config', function NewCtrl($scope,slugService,getService,postService,config){

    $scope.slugDuplicado = true;
    $scope.slugDiv = true;
    $scope.slugDivLoad = false;

    var slugView = document.getElementById("admin_paginabundle_pagina_paginaTextos_0_titulo");
    if(slugView){
        $scope.slugView = slugView.value;
    }
    var mySlug = document.getElementById("admin_paginabundle_pagina_paginaTextos_0_slug");
    if(slugView){
        $scope.mySlug = mySlug.value;
    }

    $scope.slug = function(slugView) {
        $scope.mySlug = slugService.getSlug(slugView);
    };

    $scope.verificaSlug = function(mySlug) {
        var id = document.getElementById("admin_paginabundle_pagina_id").value;
        var rota = mySlug;
        if(id){
            rota = mySlug + '/' + id;
        }
        if(mySlug != ""){
            $scope.slugDiv = false;
            $scope.slugDivLoad = true;
            getService.getService(config.urlSlug + rota).then(
                function(data){
                    $scope.slugDuplicado = data.data.status;
                    $scope.slugDiv = true;
                    $scope.slugDivLoad = false;
                    if(!data.data.status){
                        jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
                    }
                }
            );
        }
    };

    $scope.deleteFoto = function(id) {
        var dados = {id: id};
        jQuery('.modal-content .btn').hide();
        jQuery('.modal-body .loader').show();
        postService.postService(urlDeleteFoto,dados).success(function (data) {
                jQuery('.modal-content .btn').show();
                jQuery('.modal-body .loader').hide();
                if(data.status){
                    jQuery('.fechar').trigger('click');
                    jQuery('.wrap-foto').remove();
                    notificacao("Sucesso!","success","Foto removida com sucesso!");
                }else{
                    notificacao("Problema!","error","Erro ao remover a foto.");
                }
            })
            .error(function (data) {
                jQuery('.modal-body .btn').show();
                jQuery('.modal-body .loader').hide();
                notificacao("Problema!","error","Erro ao remover a foto.");
            })
    }
}]);
