angular.module("appAdmin").service("getService", function ($http) {
    this.getService = function (url) {
        return $http.get('/admin/' + url)
    }
});