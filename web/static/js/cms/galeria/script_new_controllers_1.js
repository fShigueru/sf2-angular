'use strict';
var appGaleriaControllers = angular.module('adminControllers', []);

appGaleriaControllers.controller('NewCtrl', ['$scope','$http', function NewCtrl($scope,$http){

    $scope.idEntity = true;
    var qtdeImg = document.getElementById("qtdeImg");
    if(qtdeImg){
        $scope.qtde = qtdeImg.value;
    }else{
        $scope.qtde = 1;
    }

    $scope.qtdeImage = function(rota) {
        jQuery('.modal-load').modal('show');
        var qtde = $scope.qtde;
        if(qtde == undefined){
            qtde = 1;
        }
        var url = rota + qtde;
        window.open(url, '_self');
    };

    var selectedIdEntity = jQuery('#admin_galeriabundle_galeria_entity').val();
    if(selectedIdEntity){
        $scope.itemEntity = selectedIdEntity;
        if(jQuery('#admin_galeriabundle_idEntity_idEntity > option').length > 1){
            $scope.idEntity = false;
        }
    }

    $scope.buscarRegistro = function() {
        var entity = $scope.itemEntity;
        if(entity != undefined){
            jQuery('.modal-load').modal('show');
            $scope.idEntity = true;
            var dados = {entity: entity};
            $http.post('/admin/galeria/ajax/idEntity', dados)
                .success(function (data) {
                    jQuery('.modal-load').modal('hide');
                    if(data.dados.length > 0){
                        $scope.idEntity = false;
                        var registros = data.dados;
                        jQuery('#admin_galeriabundle_idEntity_idEntity').append('<option value="">--Selecione um registro--</option>');
                        jQuery.each( registros, function( key, value ) {
                            jQuery('#admin_galeriabundle_idEntity_idEntity').append('<option value="'+key+'">' + value + '</option>');
                        });
                    }
                })
                .error(function (data) {
                    jQuery('.modal-load').modal('hide');
                    notificacao("Problema!","error","Ocorreu um problema na busca dos registros")
                })
        }
    };
}]);

appGaleriaControllers.controller('EditCtrl', ['$scope','$http', function NewCtrl($scope,$http){
    $scope.openImageFormGaleria = function(id) {
        jQuery('.image-edit-crop').hide();
        jQuery('.image-edit-crop.id'+id).show();
    };

    $scope.deleteImageGaleria = function() {
        var id = jQuery('.bt-delete-sim').val();
        var dados = {id: id};
        jQuery('.modal-load').modal('show');
        $http.post('/admin/galeria/ajax/delete/image', dados)
            .success(function (data) {
                jQuery('.modal-load').modal('hide');
                if(data.status){
                    jQuery('.image-ref-' + id).remove();
                    jQuery('.modal-footer .btn').trigger('click');
                    notificacao("Sucesso!","success",data.message);
                }else{
                    notificacao("Problema!","error",data.message);
                }
            })
            .error(function (data) {
                jQuery('.modal-load').modal('hide');
                notificacao("Problema!","error",data.message)
            });
    };

    $scope.alterarImageGaleria = function(id,index) {
        var x = jQuery('#admin_galeriabundle_galeria_image_' + index + '_proporcoes_cropStartLeft').val();
        var y = jQuery('#admin_galeriabundle_galeria_image_' + index + '_proporcoes_cropStartTop').val();
        var scale = jQuery('#admin_galeriabundle_galeria_image_' + index + '_proporcoes_scale').val();
        var titulo = jQuery('#admin_galeriabundle_galeria_image_' + index + '_textos_0_titulo').val();
        var subtitulo = jQuery('#admin_galeriabundle_galeria_image_' + index + '_textos_0_subtitulo').val();
        var descricao = jQuery('#admin_galeriabundle_galeria_image_' + index + '_textos_0_descricao').val();
        var dados = {id: id, cropStartLeft: x, cropStartTop: y, scale: scale, titulo: titulo, subtitulo: subtitulo, descricao: descricao};

        jQuery('.modal-load').modal('show');
        $http.post('/admin/galeria/ajax/update-image', dados)
            .success(function (data) {
                jQuery('.modal-load').modal('hide');
                if(data.status){
                    jQuery('.fechar').trigger('click');
                    jQuery('.wrap-foto').remove();
                    jQuery('.caption.id' + id).html(titulo);
                    notificacao("Sucesso!","success",data.message);
                }else{
                    notificacao("Problema!","error",data.message);
                }
            })
            .error(function (data) {
                jQuery('.modal-load').modal('hide');
                notificacao("Problema!","error",data.message)
            });
    }
}]);