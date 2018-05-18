'use strict';
var appPaginaControllers = angular.module('adminControllers', []);

appPaginaControllers.controller('ShowCtrl', ['$scope','Slug','$http', function NewCtrl($scope,Slug,$http){

    $scope.status = function(id) {
        var dados = {id: id};
        jQuery('.modal-content .btn').hide();
        jQuery('.modal-body .loader').show();
        $http.post('/admin/users/ajax/alterar-status', dados)
            .success(function (data) {
                jQuery('.modal-content .btn').show();
                jQuery('.modal-body .loader').hide();
                if(data.status){
                    jQuery('.modal-footer .btn').trigger('click');
                    jQuery('.btn-status').removeClass(data.statusButton.removeClassStatus);
                    jQuery('.btn-status').addClass(data.statusButton.addClassStatus);
                    jQuery('.btn-status').html(data.statusButton.message);
                    notificacao("Sucesso!","success",data.message);
                }else{
                    notificacao("Problema!","error",data.message);
                }
            })
            .error(function (data) {
                jQuery('.modal-body .btn').show();
                jQuery('.modal-body .loader').hide();
                notificacao("Problema!","error",data.message);
            })
    };

    $scope.roles = function(id) {
        var roles = jQuery( "#user_role_role").val();
        if(roles == null){
            notificacao("Atenção!",null,"Você precisa atribuir um nivel de acesso a esse usuário.");
            return false;
        }
        var dados = {id: id, roles: roles};
        jQuery('.modal-content .btn').hide();
        jQuery('.modal-body .loader').show();
        $http.post('/admin/users/ajax/alterar-role', dados)
            .success(function (data) {
                jQuery('.modal-content .btn').show();
                jQuery('.modal-body .loader').hide();
                if(data.status){
                    jQuery('.modal-footer .btn').trigger('click');
                    notificacao("Sucesso!","success",data.message);
                }else{
                    notificacao("Problema!","error",data.message);
                }
            })
            .error(function (data) {
                jQuery('.modal-body .btn').show();
                jQuery('.modal-body .loader').hide();
                notificacao("Problema!","error",data.message);
            })
    }
}]);
