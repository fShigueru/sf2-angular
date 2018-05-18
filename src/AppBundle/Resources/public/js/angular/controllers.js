'use strict';
var appControllers = angular.module('appControllers', []);

appControllers.controller('HomeCtrl', ['$scope','$http', function NewCtrl($scope,$http){

    $scope.nome = null;
    $scope.email = null;
    $scope.telefone = null;
    $scope.mensagem = null;

    $scope.sendEmail = function() {
        var dados = {'nome': $scope.nome, 'email': $scope.email, 'telefone': $scope.telefone, 'mensagem':$scope.mensagem };
        jQuery('.modal-body .loader').show();
        jQuery('.modal-load').modal('show');
        $http.post('/ajax/contato', dados)
            .success(function (data) {
                jQuery('.modal-body .loader').hide();
                jQuery('.modal-load').modal('hide');
                notificacao("Sucesso!","success",data.message);
                $scope.myFormContato.$setPristine();
                $scope.nome = null;
                $scope.email = null;
                $scope.telefone = null;
                $scope.mensagem = null;
            })
            .error(function (data) {
                jQuery('.modal-body .loader').hide();
                jQuery('.modal-load').modal('hide');
                notificacao("Problema!","error",data.message);
            })
    };

}]);
