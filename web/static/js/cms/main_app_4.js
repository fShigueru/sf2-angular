angular.module("appAdmin", ['adminControllers','slugifier'])
    .config(function($interpolateProvider){
        $interpolateProvider.startSymbol("{[{").endSymbol("}]}");
    });