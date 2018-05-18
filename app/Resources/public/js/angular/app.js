angular.module("app", ['appControllers']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol("{[{").endSymbol("}]}");
});