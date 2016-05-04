(function()
{
  var app = angular.module("appCodificacion", ['ngSanitize']);
  app.controller("CodificacionController", CodificacionController);
  
  function CodificacionController($scope, $http)
  {
    $scope.Tipo = "";
    $scope.Secuencia = "";
    
    $scope.ProcesarCodificacion = function()
    {
      $http.get("/codificacion.php?trama=" + $scope.Secuencia + "&tipo=" + $scope.Tipo).then(function(response)
      {
        $scope.ResultadoProcesamiento = response.data;
      });
    }
  }
  
}());



