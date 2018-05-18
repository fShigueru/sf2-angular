'use strict';
var appMenuControllers = angular.module('adminControllers', []);

appMenuControllers.controller('NewMenuCtrl', ['$scope','$http','$compile', function NewCtrl($scope,$http,$compile){

    $scope.nome = null;
    $scope.url = null;

    $scope.saveMenu = function() {
        if(!$scope.nome){
            notificacao("Problema!","error","Para cadastrar um novo menu, você precisa enviar um título.");
            return false;
        }

        if(!$scope.url){
            notificacao("Problema!","error","Para cadastrar um novo menu, você precisa enviar um URL válida.");
            return false;
        }

        var dados = {'nome': $scope.nome, 'url': $scope.url};
        jQuery('.modal-footer .btn').hide();
        jQuery('.modal-footer .loader').show();
        $http.post('/admin/menu/ajax/create', dados)
            .success(function (data) {
                jQuery('.modal-footer .btn').show();
                jQuery('.modal-footer .loader').hide();
                if(data.status){
                    var includeDelete = "<a onclick='getId(" + data.id + ")' data-toggle='modal' data-target='.modal-delete-menu' > <i class='fa fa-trash-o' style='float:right;' data-toggle='tooltip' data-placement='top' title='"+data.messageTitleDelete+"'></i></a>";
                    var includeItem = "<li data-id='"+data.id+"' data-name='"+dados.nome+"'>"+dados.nome+" "+includeDelete+"<ol></ol></li>";
                    jQuery( ".serialization.vertical.inativo").prepend(includeItem);
                    jQuery('.fechar').trigger('click');
                    $scope.nome = "";
                    $scope.url = "";
                    notificacao("Sucesso!","success",data.message);
                }else{
                    notificacao("Problema!","error",data.message);
                }
            })
            .error(function (data) {
                jQuery('.modal-footer .btn').show();
                jQuery('.modal-footer .loader').hide();
                notificacao("Problema!","error",data.message);
            })
    };

}]);

appMenuControllers.controller('MenuListaCtrl', ['$scope','$http', function NewCtrl($scope,$http){
    $scope.saveMenuLista = function() {
        var dados = jQuery('.lista-menu').val();
        jQuery('.modal-load').modal('show');
        $http.post('/admin/menu/ajax/lista', dados)
            .success(function (data) {
                jQuery('.modal-load').modal('hide');
                notificacao("Sucesso!","success",data.message);
            })
            .error(function (data) {
                jQuery('.modal-load').modal('hide');
                notificacao("Problema!","error",data.message);
            })
    };

    $scope.deleteMenu = function() {
        jQuery('.modal-delete-menu').modal('hide');
        jQuery('.modal-load').modal('show');
        var id = jQuery('.bt-delete-sim').val();
        var dados = {'id': id};
        $http.post('/admin/menu/ajax/delete', dados)
            .success(function (data) {
                jQuery('.modal-load').modal('hide');
                if(data.status){
                    notificacao("Sucesso!","success",data.message);
                    setTimeout(function(){
                        window.location.reload(1);
                    }, 4000);
                }else{
                    notificacao("Problema!","error",data.message);
                }
            })
            .error(function (data) {
                jQuery('.modal-load').modal('hide');
                notificacao("Problema!","error",data.message)
            })
    };
}]);
