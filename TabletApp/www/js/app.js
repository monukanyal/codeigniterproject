(function(){
  'use strict';
  var module = angular.module('app', ['onsen','checklist-model','angular.chosen']);


 module.controller('CommunityController', function($scope, $data) {
     
    /****** load app when user is loggedIn  ******/
    angular.element(document).ready(function () {

        var currentuser = JSON.parse(localStorage.getItem("com_current_user"));

        if(currentuser != null || currentuser != undefined)
        {
            $scope.comm.pushPage('home.html',{ animation : 'lift' });
        }

        console.log($scope.comm.getCurrentPage());
        

        var current = $scope.comm.getCurrentPage();
        // alert(current);

          $scope.goBack = function() {
             if(current.page != 'home.html') {
               $scope.comm.popPage(current.page);
             };
          }

          $scope.goHome = function() {
              $scope.comm.pushPage('home.html',{ animation : 'fade'});
          }
        });

  });


  module.controller('loginController', function($scope, $data) {

    $scope.login_user = function(user) {

        modal.show();

        $data.loginform(user).then(function(credentials){
          // alert("inside login");
            if(credentials[0].status == 'Success')
            {
               modal.hide();
              // alert("success");
              //console.log(credentials[0].staff_id);
              var staff =  {
                staffId : credentials[0].staff_id,
                orgId   : credentials[0].org_id
              }
                $scope.comm.pushPage('home.html',{ animation : 'slide' });
                window.localStorage.setItem("com_current_user", JSON.stringify(staff));
            }
            else
            {
               // alert("fail");
               // $scope.errorMsg = credentials[0].message;
                ons.notification.alert({
                    message: "Invalid username or password. Please try again.",
                    title: "Error",
                    buttonLabel: "OK"
                });
                modal.hide();
            }
        });
    }
  });


module.controller('PlanHomeController', function($scope, $data) {
    

});

  module.controller('PlanActivityController', function($scope, $data) {

      $scope.startdate = new Date();
      $scope.enddate = new Date();     

      $data.ManageLocation().then(function(res){
            $scope.locations = res;
      });

      $data.ManageEvents().then(function(res){
            $scope.listevents = res;
      });

      $scope.IsVisible = false;

      $scope.ShowHide_date = function () {
          //If DIV is visible it will be hidden and vice versa.
          $scope.IsVisible = $scope.activity_nodate;
      }

      $scope.checkErr = function(startDate,endDate) {
        $scope.errMessage = '';
        var curDate = new Date();

        if(new Date(startDate) > new Date(endDate)){
          //$scope.errMessage = 'End Date should be greater than or equals to start date';
          ons.notification.alert({
                message: 'End Date should be greater than or equals to start date',
                title: "Error",
                buttonLabel: "OK"
          });
          return false;
        }
        // if(new Date(startDate) < curDate){
        //    $scope.errMessage = 'Start date should not be before today.';
        //    return false;
        // }
      };

      $scope.checkTime = function(starttime,endtime) {
        $scope.errMessage = '';
        var curDate = new Date();

        var getstarttime = new Date(starttime);
        getstarttime.setHours(getstarttime.getHours(), getstarttime.getMinutes());

        var getendtime = new Date(endtime);
        getendtime.setHours(getendtime.getHours(), getendtime.getMinutes());

        if(getstarttime > getendtime){
          //$scope.errMessage = 'End time should be after start time';
            ons.notification.alert({
                  message: 'End time should be after start time',
                  title: "Error",
                  buttonLabel: "OK"
            });
          return false;
        }
        // if(new Date(startDate) < curDate){
        //    $scope.errMessage = 'Start date should not be before today.';
        //    return false;
        // }
      };

      

      $scope.options = [
      { 'Id' : 'S', 'value' : 'S'  },
      { 'Id' : 'M', 'value' : 'M'  },
      { 'Id' : 'T', 'value' : 'T'  },
      { 'Id' : 'W', 'value' : 'W'  },
      { 'Id' : 'Th','value' : 'Th' },
      { 'Id' : 'F', 'value' : 'F'  },
      { 'Id' : 'St','value' : 'St' }
      ];

      // console.log($scope.options);

     $scope.saveEvent = function(activity) {

      console.log(activity);
      var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 

      $scope.pusharray = [];
      var reval = '';

      $scope.options.forEach(function(option,i) {
        if(option.value == true){
          i = $scope.pusharray.push(option.Id);
          if(i > 1)
          {
            reval += ',';
          }
          reval += option.Id;
        }
      });

      var startdate = $scope.startdate.getFullYear() + "/" + $scope.startdate.getMonth() + "/" + $scope.startdate.getDate();
      var enddate = $scope.enddate.getFullYear() + "/" + $scope.enddate.getMonth() + "/" + $scope.enddate.getDate();

      var dtstart  = new Date(activity.starttime);
      var start_time =  dtstart.getHours() + ":" + dtstart.getMinutes();

      var dtend  = activity.endtime;
      var end_time =  dtend.getHours() + ":" + dtend.getMinutes();


      var getstartdate = startdate+" "+dtstart;

      var getenddate = enddate+" "+dtstart;


      /*start = moment(getstartdate);
      remainder = (15 - start.minute()) % 15;
      var gstarttime = moment(start).add("minutes", remainder ).format("hh:mm a");

      end   = moment(getenddate);
      remainder = (15 - end.minute()) % 15;
      var gendtime = moment(end).add("minutes", remainder ).format("hh:mm a");*/

 
      // console.log(start_time);
      
      activity.staff_id      = usersdata.staffId;
      activity.org_id        = usersdata.orgId;
      activity.event_id      = activity.listevent.id;
      activity.description   = activity.listevent.description;
      activity.location_id   = activity.location.id;
      activity.max_attendies = activity.listevent.max_attendies;
      activity.meetup_date   = $scope.startdate;
      activity.end_date      = $scope.enddate;
      activity.meetup_time   = start_time;
      activity.end_time      = end_time;
      activity.recurring     = reval;

      if($scope.IsVisible == false)
      {
         activity.no_end_date = "0";
      }
      else
      {
         activity.no_end_date = "1";
      }
      
// console.log(activity);
      $data.addevent(activity).then(function(res){
        console.log(res);
        if(res.data[0].status == 'Success') {
            $scope.message = res.data[0].message;
            $scope.activity = {};
        }
      }); 
    }
  });


  module.controller('ManageActivityController',function($scope, $data) {

    modal.show();
    $scope.users = $data.selectedItem;
    $scope.listEventUsers = '';

    $data.listEventsbydate().then(function(res){
      modal.hide();
        $scope.alltodayEvents = res[0];
        $scope.listevents = [];
        if($scope.alltodayEvents.status == 'Error'){
          $scope.errMessage = "No Activity for today";
        }
        angular.forEach($scope.alltodayEvents,function(res){
         $scope.listevents.push(res);
        });
       
    });



    $data.ManageUsers().then(function(res){
       modal.hide();
       $scope.listusers = res;
    });


    $scope.showSearch = false;
    $scope.addActivity = false;
    $scope.addUser = false;

    $scope.getuserval =  function(username){
          $scope.addUser = true;
    }


    $scope.getselectval = function(events) {
      modal.show();
      // console.log(events);
      
      if(events == null) {
        var manageeventId = '';
      }
      else {
        var manageeventId = events.id;
        $scope.addActivity = true;
      }
      
      $scope.selectedvalues = { 'id' : manageeventId};
      var eventid = $scope.selectedvalues.id;

     
      $data.ManageEventUsers(eventid).then(function(res) {
         modal.hide();

         $scope.showSearch = true;
         $scope.listEventUsers = res;

      $scope.orderList = "first_name"+"last_name";

      $data.selectedattendUsers(eventid).then(function(res){
          $scope.selectedusers = res.users; 
          $scope.selectusers = [];

          $scope.selectedusers.forEach(function(useroption) {
            $scope.selectedoptions = useroption.userid;
            $scope.selectusers.push($scope.selectedoptions);
            if($scope.selectusers == '') { 
              $scope.selectedUsers = [];
            }
            else {
             $scope.selectedUsers = $scope.selectusers;
            }
            //window.localStorage.setItem("selectedUsers", JSON.stringify(selected));
          });

          if($scope.selectedUsers.length == 1)
          {
              $scope.selectedUsers.push("0");
          }
       
        

          console.log( $scope.selectedUsers );


          $scope.check_users = function() {
              modal.show();


              var userid = $scope.selectedUsers;
              // alert(userid);

              var adduser = {
                event_id : eventid,
                user_id  : userid
              }
                
              $data.attendEventUsers(adduser).then(function(res){
                 modal.hide();
                // if(res[0].status == 'Success') {
                //     ons.notification.alert({
                //         message: 'Attendance list updated!!'
                //     });
                // }
              });
          }

        // $scope.selectedUsers = JSON.parse(localStorage.getItem("selectedUsers")); 
        });
    });

    

    $scope.adduser = function(manageact) {

       modal.show();
       $scope.addUser = true;
      
        var weekday          =  $scope.listevents[0].event_date;
        $scope.day_option    =  weekday.split(' ');
        manageact.userId     =  manageact.manage_user.id;
        manageact.eventid    =  eventid;
        manageact.useroption =  "8";
        manageact.singleDate =  $scope.day_option[1];

       // console.log(manageact);        

        $data.addUserEventrange(manageact).then(function(res){
           modal.hide();
            if(res[0].status == 'Success') {
                ons.notification.alert({
                  message: 'Attendance list updated!!'
                });
                $scope.getselectval(events);
            }
            else {
                ons.notification.alert({
                  message: res[0].message
                });
            }
        }); 
    }
  }

   

  });

  module.controller('ManageMealController', function($scope, $data) {

    modal.show();

    $scope.meals = $data.selectedItem;
    $scope.listMealUsers = '';


    $data.listMealbyday().then(function(res){
       modal.hide();

        $scope.alltodayMeals = res[0];

        // console.log($scope.alltodayMeals);

        if($scope.alltodayMeals.status == 'Error'){
          $scope.errMessage = "No Meal for today";
        }

        angular.forEach($scope.alltodayMeals,function(res){
             $scope.listmeals = res;
        });
    });
    $data.ManageUsers().then(function(res){
       modal.hide();
       $scope.listusers = res;
    });


    $scope.showSearchmeal = false;
    $scope.addMeal = false;
    $scope.addUser = false;

    $scope.getmealuser =  function(username){
           $scope.addUser = true;
    }

    $scope.getselectval = function(meal) {
      modal.show();

      // $scope.addUser = true;

      // console.log(meal.id);
      if(meal == null) {
        var managemealId = '';
      }
      else {
        var managemealId = meal.id;
        $scope.addMeal = true;
      }
      

      $scope.selectedvalues = { 'id' : managemealId }
      var mealid = $scope.selectedvalues.id;
      
      $data.ManageMealUsers(mealid).then(function(res) {
        modal.hide();
        $scope.showSearchmeal = true;
        $scope.listMealUsers = res;

        $scope.orderList = "first_name"+"last_name";

        $data.selectedattendmealUsers(mealid).then(function(res){
          $scope.selectedusers = res.users; 
          $scope.selectusers = [];

          $scope.selectedusers.forEach(function(useroption) {
            $scope.selectedoptions = useroption.userid;
            $scope.selectusers.push($scope.selectedoptions);
             if($scope.selectusers == '') { 
              $scope.selectedUsers = [];
            }
            else {
             $scope.selectedUsers = $scope.selectusers;
            }
            //window.localStorage.setItem("selectedUsers", JSON.stringify(selected));
          });

        // $scope.selectedUsers = [];
        if($scope.selectedUsers.length == 1)
        {
            $scope.selectedUsers.push("0");
        }
                
        $scope.check_users = function() {

            modal.show();

            var userid = $scope.selectedUsers;
            // alert(userid);

            var adduser = {
              meal_id  : mealid,
              user_id  : userid
            }
            // console.log(adduser);

            $data.attendMealUsers(adduser).then(function(res){
               modal.hide();
              // if(res[0].status == 'Success') {
              //     ons.notification.alert({
              //         message: 'Attendance list updated!!'
              //     });
              // }
            });
        }


        });

      //$scope.selectedUsers = JSON.parse(localStorage.getItem("selectedUsers")); 
      });
    

    $scope.adduser = function(managemeal) {
        modal.show();
        $scope.addUser = true;

        console.log(managemeal);
        $scope.options = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        var weekday           =  $scope.listmeals[0].start_date;
        $scope.day_option     =  weekday.split(' ');
        managemeal.userId     =  managemeal.manage_user.id;
        managemeal.mealid     =  mealid;
        managemeal.useroption =  $scope.options.indexOf($scope.day_option[0]);
        managemeal.meal_date  =  $scope.day_option[1];
        managemeal.meal_time  =  $scope.listmeals[0].start_time;

        $data.addUserMealrange(managemeal).then(function(res){
           modal.hide();
            if(res[0].status == 'Success') {
                 ons.notification.alert({
                  message: 'Attendance list updated!!'
                });
                $scope.getselectval(meal);
            }
            else {
                 ons.notification.alert({
                  message: res[0].message
                });
            }
        });

    };
  }
  });


  module.controller('SendNotifyController', function($scope, $data) {
      modal.show();

     $data.ManageUsers().then(function(res){
      modal.hide();
         $scope.listusers = res;
    });

    $data.listActivities().then(function(res){
      modal.hide();
         $scope.listallevents = res;
         console.log($scope.listallevents);
         $scope.listallevents.forEach(function(res){
                $scope.listevents = res;
          });
    });

    // $scope.showUsers = false;
    $scope.showModal = false;
    $scope.toggleModal = function(){
        $scope.showModal = !$scope.showModal;
    };



    $scope.send_users_notify = function(){
        // $scope.showUsers = true;
        // $scope.showUsers = $scope.showUsers ? false : true;
        // $scope.showActivity =  false;

        $scope.comm.pushPage('notify1.html',{ animation : 'fade' });
    }


    $scope.users_notification = function(userid) {
      $scope.comm.pushPage('sendmsg1.html',{ animation : 'lift' });
      $scope.userId = userid;
       window.localStorage.setItem('msguserid', JSON.stringify($scope.userId));
    }
    $scope.send_msg1 = function(message){

        var userId = JSON.parse(localStorage.getItem("msguserid"));
        var text   = message.text;
         $data.SendUsersms(userId,text).then(function(res) {
            $scope.comm.pushPage('home.html',{ animation : 'fade' }); 
        });
           ons.notification.alert({
            message: 'Message sent successfully!'
          });
         $scope.comm.pushPage('home.html',{ animation : 'fade' });
    }

    // $scope.showActivity = false;

    $scope.send_activity_notify = function() {
       // $scope.showActivity = true;
        // $scope.showActivity = $scope.showActivity ? false : true;
        // $scope.showUsers =  false;
        $scope.comm.pushPage('notify2.html',{ animation : 'fade' });
    }
    

    $scope.activity_notification = function(eventid) {

      $scope.comm.pushPage('sendmsg2.html',{ animation : 'lift' });
      $scope.eventId = eventid;
       window.localStorage.setItem('msgeventid', JSON.stringify($scope.eventId));
     }

     $scope.send_msg2 = function(message){

        var eventId = JSON.parse(localStorage.getItem("msgeventid"));
        var text   = message.text;

         $data.SendActivitySms(eventId,text).then(function(res) {
          
          // ons.notification.alert({
          //   message: 'Message sent successfully!'
          // });
         $scope.comm.pushPage('home.html',{ animation : 'fade' });
        });
          ons.notification.alert({
            message: 'Message sent successfully!'
          });
        $scope.comm.pushPage('home.html',{ animation : 'fade' });
    }

        
    
    

    $scope.send_allusers = function() {
      $scope.comm.pushPage('sendmsg3.html',{ animation : 'lift' });
    }
       // $scope.showUsers =  false;
       // $scope.showActivity = false;

    $scope.send_msg3 = function(message){

      var text   = message.text;

        $data.SendAllUsersSms(text).then(function(res) {
         $scope.comm.pushPage('home.html',{ animation : 'fade' });
        });
          ons.notification.alert({
            message: 'Message sent to all users!'
          });
         $scope.comm.pushPage('home.html',{ animation : 'fade' });
    }


  });







 module.factory('$data',function($http) {

    var data = {};
    // var apiUrl = 'http://67.227.228.88/~development002/community/index.php/api';
     var apiUrl = 'http://52.43.178.84/index.php/api';
    //var apiUrl = 'http://52.88.242.243/index.php/api';
    //var apiUrl = 'http://www.yourday.io/index.php/api';


    data.loginform = function(user) {
          // alert("inside factory");
          var userlogin = $http.get(apiUrl +'?func=staffLogin&sec_token=YHDgjy9Q7yuDFgTE&email='+user.email+'&password='+user.password).then( function(loginData){
              return loginData.data;
        });
        return userlogin;
    };

    data.addevent = function(activity) {

      activity.sec_token = 'YHDgjy9Q7yuDFgTE';

      var add_event = $http({
        method: 'POST',
        url : apiUrl + '?func=addEvent',
        data: activity
      }).then(function(res){
        return res;
      });
      return add_event;
    }

    data.addmeal = function(meal) {

      meal.sec_token = 'YHDgjy9Q7yuDFgTE';
     
      var add_meal = $http({
        method: 'POST',
        url : apiUrl + '?func=addMeal',
        data: meal
      }).then(function(res){
        console.log(res);
        return res;
      });
      return add_meal;
    }

    data.ManageUsers = function() {
      var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var orgid = usersdata.orgId;

        var Userlist = $http.get(apiUrl +'?func=getUserList&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid).then( function(response){
              return response.data;
              //console.log(response.data);
        });
        return Userlist;
    };

    data.ManageEvents = function() {
      var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
      var orgid = usersdata.orgId;

      var listEvents = $http.get(apiUrl +'?func=listManageEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid).then( function(response){
            return response.data;
            console.log(response.data);
      });
      return listEvents;
    };

    data.ManageLocation = function() {
      var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var orgid = usersdata.orgId;

          var listLocation = $http.get(apiUrl +'?func=listManageLocation&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid).then( function(response){
              return response.data;
              //console.log(response.data);
        });
        return listLocation;
    };

    data.listEventsbydate = function() {
       var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var orgid = usersdata.orgId;

        var listEvents = $http.get(apiUrl +'?func=listEventsbydate&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid).then( function(response){
              return response.data;
              //console.log(response.data);
        });
        return listEvents;
    }

    data.ManageEventUsers = function(eventid) {
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var orgid = usersdata.orgId;
        var Userlist = $http.get(apiUrl +'?func=getjoinedEventUsers&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid+'&event_id='+eventid).then( function(response){
              return response.data;
              //console.log(response.data);
        });
        return Userlist;
    };


    data.addUserEventrange = function(manageact) {
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var add_eventuser = $http.get(apiUrl + '?func=addEventrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+manageact.useroption+'&id='+manageact.eventid+'&singledate='+manageact.singleDate+'&user_id='+manageact.userId+'&org_id='+usersdata.orgId).then(function(response) {
          // console.log(response.data);
          return response.data;
        });
        return add_eventuser;
    }

    data.attendEventUsers = function(adduser){
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var attend_userevent = $http.get(apiUrl + '?func=attendEventUsers&sec_token=YHDgjy9Q7yuDFgTE&id='+adduser.event_id+'&user_id='+adduser.user_id+'&org_id='+usersdata.orgId).then(function(response) {
          // console.log(response.data);
          return response.data;
        });
        return attend_userevent;
    }

    data.deleteattendEventUsers = function(adduser) {
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var attend_userevent = $http.get(apiUrl + '?func=deleteattendEventUsers&sec_token=YHDgjy9Q7yuDFgTE&id='+adduser.event_id+'&user_id='+adduser.user_id+'&org_id='+usersdata.orgId).then(function(response) {
          // console.log(response.data);
          return response.data;
        });
        return attend_userevent;
    }

    data.selectedattendUsers = function(eventid) {
        var currentuser   = JSON.parse(localStorage.getItem("com_current_user")); 
        var selectedusers = $http.get(apiUrl + '?func=selectedattendUsers&sec_token=YHDgjy9Q7yuDFgTE&id='+eventid).then(function(response){
          return response.data;
        });
        return selectedusers;
    }


    // data.ManageMeals = function() {

    //   var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
    //     var orgid = usersdata.orgId;

    //       var listEvents = $http.get(apiUrl +'?func=listManageEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid).then( function(response){
    //           return response.data;
    //           console.log(response.data);
    //     });
    //     return listEvents;
    // };

    data.listMealbyday = function() {
       var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var orgid = usersdata.orgId;

        var listMeals = $http.get(apiUrl +'?func=listMealbyday&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid).then( function(response){
              return response.data;
              //console.log(response.data);
        });
        return listMeals;
    };


    data.ManageMealUsers = function(mealid) {
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var orgid = usersdata.orgId;
          var Userlist = $http.get(apiUrl +'?func=getjoinedMealUsers&sec_token=YHDgjy9Q7yuDFgTE&org_id='+orgid+'&meal_id='+mealid).then( function(response){
              return response.data;
              //console.log(response.data);
        });
        return Userlist;
    };

    data.addUserMealrange = function(managemeal) {
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var add_mealuser = $http.get(apiUrl + '?func=addMealrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+managemeal.useroption+'&id='+managemeal.mealid+'&meal_date='+managemeal.meal_date+'&meal_time='+managemeal.meal_time+'&user_id='+managemeal.userId+'&org_id='+usersdata.orgId).then(function(response) {
          // console.log(response.data);
          return response.data;
        });
        return add_mealuser;
    };

    data.attendMealUsers = function(adduser){
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var attend_userevent = $http.get(apiUrl + '?func=attendMealUsers&sec_token=YHDgjy9Q7yuDFgTE&id='+adduser.meal_id+'&user_id='+adduser.user_id+'&org_id='+usersdata.orgId).then(function(response) {
          // console.log(response.data);
          return response.data;
        });
        return attend_userevent;
    };

    data.deleteattendMealUsers = function(adduser) {
        var usersdata = JSON.parse(localStorage.getItem("com_current_user")); 
        var attend_userevent = $http.get(apiUrl + '?func=deleteattendMealUsers&sec_token=YHDgjy9Q7yuDFgTE&id='+adduser.meal_id+'&user_id='+adduser.user_id+'&org_id='+usersdata.orgId).then(function(response) {
          // console.log(response.data);
          return response.data;
        });
        return attend_userevent;
    }

    data.selectedattendmealUsers = function(mealid) {
        var usersdata   = JSON.parse(localStorage.getItem("com_current_user")); 
        var selectedusers = $http.get(apiUrl + '?func=selectedattendmealUsers&sec_token=YHDgjy9Q7yuDFgTE&id='+mealid).then(function(response){
          return response.data;
        });
        return selectedusers;
    }

    data.listActivities = function(){
        var usersdata   = JSON.parse(localStorage.getItem("com_current_user")); 
        var events = $http.get(apiUrl +'?func=listActivities&sec_token=YHDgjy9Q7yuDFgTE&org_id='+usersdata.orgId).then(function(response){
           // console.log(response.data);
          return response.data;
        });
        return events;
    }

    data.SendUsersms = function(userid,text){
        var usersdata   = JSON.parse(localStorage.getItem("com_current_user")); 
        var sms = $http.get(apiUrl +'?func=send_users_sms&sec_token=YHDgjy9Q7yuDFgTE&user_id='+userid+'&org_id='+usersdata.orgId+'&message='+text).then(function(response){
           // console.log(response.data);
          return response.data;
        });
        return sms;
    }


  data.SendActivitySms = function(eventid,text){
        var usersdata   = JSON.parse(localStorage.getItem("com_current_user")); 
        var sms = $http.get(apiUrl +'?func=send_activitysms&sec_token=YHDgjy9Q7yuDFgTE&event_id='+eventid+'&org_id='+usersdata.orgId+'&message='+text).then(function(response){
           // console.log(response.data);
          return response.data;
        });
        return sms;
    }


  data.SendAllUsersSms = function(text) {
      var usersdata   = JSON.parse(localStorage.getItem("com_current_user")); 
      var sms = $http.get(apiUrl +'?func=send_allusers&sec_token=YHDgjy9Q7yuDFgTE&org_id='+usersdata.orgId+'&message='+text).then(function(response){
             // console.log(response.data);
            return response.data;
          });
          return sms;
  }
      
      return data;
  });



})();

