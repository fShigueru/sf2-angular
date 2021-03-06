'use strict';
var appNoticiaCategoriaCtrl = angular.module('adminControllers', []);
appNoticiaCategoriaCtrl.controller('NewCtrl', ['$scope','slugService','postService','config', function NewCtrl($scope,slugService,postService,config){

    $scope.slugDuplicado = false;
    $scope.slugDiv = true;
    $scope.slugDivLoad = false;
    $scope.messageSlugDuplicado = null;

    $scope.slug = function(slugView) {
        $scope.mySlug = slugService.getSlug(slugView);
    };

    $scope.verificaSlug = function(mySlug) {
        var data = {slug: mySlug};
        if(mySlug){
            $scope.slugDiv = false;
            $scope.slugDivLoad = true;
            postService.postService(data,config.urlSlug).then(
                function(data){
                    $scope.slugDiv = true;
                    $scope.slugDivLoad = false;
                    if(!data.data.status){
                        $scope.slugDuplicado = true;
                        $scope.messageSlugDuplicado = data.data.message;
                        jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
                    }
                }
            );
        }
    };
}]);
