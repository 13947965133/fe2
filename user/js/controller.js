var sname ='未选择店家';
var zhuohao = "未选择桌号";
var ab = location.href.split("?");
$.cookie('dizhi', ab[1],{ expires: 7, path: '/' });
var ws3 = ab[1].split('&');
for (var i = 0; i < ws3.length; i++) {
	ws4 = ws3[i].split('=');
	switch (ws4[0]) {
		case 'sid':
			usesid = ws4[1];
			break;
		case 'sname':
			sname = ws4[1];
			break;
		case 'zid':
			zhuohao = ws4[1];
			break;
		default:
			console.log("url is orrer");

	}
}
angular.module('starter.controllers', ['ngStorage','ngAnimate'])
	//首页
.controller('HomeCtrl', function ($scope,$http,$rootScope, $ionicScrollDelegate, $sessionStorage,$interval,$state,$animate) {
	document.title= decodeURI(sname)+":"+zhuohao+"号桌";
	$http({
		url:"app_data/"+usesid+".json",
		method:"get"
	}).success(function(data){
		$scope.footList = data;
		$rootScope.leftNum = 1;
		$rootScope.num = {};
		$rootScope.zongjia = 0;
		$rootScope.zongshu = 0;
		$rootScope.shopping = {};
	});

	$scope.plus = function (x) {
		$rootScope.num[x.id] = $rootScope.num[x.id]?++$rootScope.num[x.id]:1;
		$rootScope.zongshu++;
		$rootScope.zongjia += Number(x.jiage);
		if($rootScope.shopping[x.id]){
			$rootScope.shopping[x.id].num++;
		}else{
			$rootScope.shopping[x.id] = {
				id: x.id,
				name: x.name,
				num: 1,
				jiage: x.jiage
			};
		}
	};
	$scope.minus = function (x) {
		$rootScope.num[x.id]--;
		$rootScope.zongshu--;
		$rootScope.zongjia -= Number(x.jiage);
		$rootScope.shopping[x.id].num--;
		if($rootScope.shopping[x.id].num == 0){
			delete $rootScope.shopping[x.id];
		}
	};
	$scope.jump = function (id) {
		window.location = '#/tab/detail/'+id;
	};
	$scope.onScroll = function(){
		var scrollTop = $ionicScrollDelegate.$getByHandle('scrollRight').getScrollPosition().top;
		var num = 0;
		for(var i = 0;i < $rootScope.arr.length;i++){
			if(scrollTop >= $rootScope.arr[i]){
				num = i;
			}
		}
		$rootScope.leftNum = num+1;
	};
	$scope.dian = function(id){
		$rootScope.leftNum = id;
		$ionicScrollDelegate.$getByHandle('scrollRight').scrollTo(0,$rootScope.arr[id-1],'ease');
	};
	$scope.show = false;
	$scope.shop = function(){
		$scope.show = !$scope.show;
	};
	$rootScope.personNum = 2;
	$scope.statements = function(){
		window.location = '#/tab/confirm';
	};
	$interval(function(){});
})
	//详情页
.controller('DetailCtrl',function($scope,$http,$rootScope,$stateParams){
	$scope.footList = {};

	$http({
		url:"app_data/list.json",
		method:"get"
	}).success(function(data){
		for(var i = 0;i < data.length;i++){
			for(var j = 0;j < data[i].list.length;j++){
				if(data[i].list[j].id == $stateParams.id){
					$scope.footList = data[i].list[j];
					break;
				}
			}
		}
	});
	$scope.plus = function (x) {
		$rootScope.num[x.id] = $rootScope.num[x.id]?++$rootScope.num[x.id]:1;
		$rootScope.zongshu++;
		$rootScope.zongjia += Number(x.jiage);
	};
	$scope.minus = function (x) {
		$rootScope.num[x.id]--;
		$rootScope.zongshu--;
		$rootScope.zongjia -= Number(x.jiage);
	};
	$scope.back = function(){
		window.location = '#/tab/home';
	};
})
.controller('ConfirmCtrl',function($scope,$rootScope,$http){
	$scope.beizhu = "订单备注为空";
	$rootScope.personNum = 2;
	$scope.back = function(){
		window.location = '#/tab/home';
	};
	$scope.personPlus = function(){
		$rootScope.personNum++;
	};
	$scope.personMinus = function(){
		$rootScope.personNum--;
	}
	//var data
	$scope.tijiao = function(){
		$.post("ding.php",
    {
			Name:decodeURI(sname),
			sid: usesid,
			zid:zhuohao,
			list:JSON.stringify($rootScope.shopping),
			sum: $rootScope.zongjia,
			renshu: $rootScope.personNum,
			zhifu: "现金支付",
			bz: $scope.beizhu
    },
        function(data,status){
					if (data ==1){
						$("#tijiaor").text("已下单");
						$("#tijiaor").attr("disabled",true);
						$("#tijiaor").css("background-color","#FEB252");
						$("#tijiaor").css("border","1px solid #FEB252");
						if(confirm("订单已发送到商家,是否确认关闭页面")){
							var tdizhi = $.cookie('dizhi');
							window.location="http://www.imnu.online/fe2/user/#/tab/home?"+tdizhi;
							window.location.reload();
						 }
					}else {
						alert("网络错误,请重新下单");
						var tdizhi = $.cookie('dizhi');
						window.location="http://www.imnu.online/fe2/user/#/tab/home?"+tdizhi;
						window.location.reload();
					}
    });

	}
})
	//获取每一个list的位置
.directive('lastIndex',function($rootScope){
	$rootScope.arr = [];
	return {
		restrict: 'A',
		link: function(scope,element,attr){
			if(scope.$first){
				$rootScope.arr.push(element.parent().parent().position().top);
			}
		}
	}
})
