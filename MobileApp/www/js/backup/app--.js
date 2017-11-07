(function(){
  'use strict';
  var module = angular.module('app', ['onsen']);


  module.controller('MainController', function($scope,$data) {

    ons.ready(function() {

    $scope.initAds = function() {
       
      if (admob) {
         alert("Admob Plugin");
        var adPublisherIds = {
          ios : {
            banner : "ca-app-pub-4696684958819953~3818287028",
            interstitial : "ca-app-pub-4696684958819953/2003476626"
          },
          android : {
            banner : "ca-app-pub-4696684958819953~6771753422",
            interstitial : "ca-app-pub-4696684958819953/6352951021"
          }
        };

        var admobid = (/(android)/i.test(navigator.userAgent)) ? adPublisherIds.android : adPublisherIds.ios;

        admob.setOptions({
          publisherId:          admobid.banner,
          interstitialAdId:     admobid.interstitial,
          adSize:               admob.AD_SIZE.SMART_BANNER,
          bannerAtTop:          true,
          overlap:              true,
          offsetStatusBar:      true,
          isTesting:            false,
          adExtras :            {},
          autoShowBanner:       true,
          autoShowInterstitial: true
        });

        //registerAdEvents();

      } else {
        alert('AdMobAds plugin not ready');
      }
    }

    $scope.randomNumber = function(minimum, maximum) {
        return Math.round( Math.random() * (maximum - minimum) + minimum);
    }

    $scope.makeid = function(length)
    {
        var text = "";
        var possible = "0123456789ABCDEF";
        for( var i=0; i < length; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }

    var first    = $scope.randomNumber(0,9);
    var second   = $scope.makeid(3);  
    var uniqueid = first+'x'+second;

    // console.log(uniqueid);'1xCDE'

    $scope.login = function() {
           $data.getUserInfo('4xE18').then(function(res){
                if(res[0].status == 'Success') {
                      modal.hide();
                      var userlogin =  {
                        userId   : res[0].user_id,
                        orgId    : res[0].org_id,
                        username : res[0].username
                      }
                      window.localStorage.setItem('current_user', JSON.stringify(userlogin));
                      $scope.mob.pushPage('home.html',{ animation : 'fade' });
                      location.reload(true);
                }
                else {
                  alert("fail");
                  // $scope.logout();
                  setTimeout(function(){
                    $scope.login();
                  },2000);
                }

           });
    }
        // $scope.logout = function(){
        //     window.localStorage.clear();
        //     navigator.app.exitApp();
        //     // $scope.mob.pushPage('landing.html',{ animation : 'fade'});
        // }

       // $scope.login();
        

        $scope.app_sendSms = function() {
              modal.show();
              $scope.login();
              
            // Send Sms //
            // var number = '+15125663933';
            //   // var number = '+919646138556';
            //   var message = 'This is a test message of the emergency system.Testing function {'+uniqueid+'} to ensure alerting is working please press send now';
            //   //CONFIGURATION
            //   var intent = '';
            //   var success = function () {
            //       modal.show();
            //       $scope.login();
            //       //alert('Message sent successfully'); 
            //   };
            //   var error = function (e) { 
            //      modal.hide();
            //      alert("Please send message for verification"); 
            //   };
            //   sms.send(number, message, intent, success, error);
        }


        $scope.mydayactivity_detail = "";

         var currentuser = JSON.parse(localStorage.getItem("current_user"));
         

         // console.log(currentuser);

         if(currentuser == '' || currentuser != null || currentuser != undefined)
         {
              //$scope.login();
            $scope.username = currentuser.username;
            $scope.mob.pushPage('home.html',{ animation : 'fade'});

            // $scope.initAds();

            // admob.createBannerView();

            // // request an interstitial
            // admob.requestInterstitialAd();
         }

         var current = $scope.mob.getCurrentPage();

         $scope.goBack = function(){
             if(current.page != 'home.html'){
               $scope.mob.popPage(current.page);
             }
             else
             {
                $scope.goHome();
             }
          }
          $scope.goHome = function() {
              $scope.mob.pushPage('home.html',{ animation : 'fade'});
          }
         
          
        $scope.backKeyDown = function(){
          var current = $scope.mob.getCurrentPage();
          if(current.page == 'home.html')
          {
              navigator.app.exitApp();
              //ons.notification.confirm("Are you sure you want to exit ?", onConfirm, "Confirmation", "Yes,No");
          }
        }

        $scope.gettime = function(time){
          // alert(time);
          // var d = new Date(time);
            var elem = time.split(':');
            // var stSplit = elem[1].split(":");// alert(stSplit);
            var stHour = elem[0];
            var stMin = elem[1];
            // var stAmPm = elem[2];
            var newhr = 0;
            var ampm = '';
            var newtime = '';            

            if (stHour < 12 && stHour != '00') {
                return stHour + ':' + stMin + ' AM';
            } else if(stHour > 12) {
                stHour=stHour - 12;
                stHour=(stHour.length < 10) ? '0'+stHour:stHour;
                return stHour+ ':' + stMin + ' PM';
            }
            else if(stHour == '00') {
              stHour= '12';
              return stHour+ ':' + stMin + ' AM';
            }
            else if (stHour == '12') {
              stHour= '12';
              return stHour+ ':' + stMin + ' PM';
            }  
            // return '12';
        }

        $scope.getday = function(day){
               $scope.currentday = day ;

              $scope.daysarr  = [ 'today','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday'];
             
              return $scope.daysarr[day];
              // console.log($scope.daysarr[day]);
        }



    $scope.activetab = 0;
    $scope.mob.on('postpush',function(event){
        if(event.enterPage.page == 'tabs.html')
        {
          bottomtab.setActiveTab($scope.activetab);
        }
    });

    $scope.opentab = function(active) {
      $scope.activetab = active;
      $scope.mob.pushPage('tabs.html',{ animation : 'slide' }); 
    };

    $scope.selected = 0;

    $scope.showEvents = function(index) {

        $data.listEvents(currentuser).then(function(res) {
          $scope.events  = res;
          $scope.org_id  = currentuser.orgId;
          $scope.user_id = currentuser.userId;
          // $scope.ekeys = Object.keys($scope.events);
          $scope.getevents = $scope.events[0];

          console.log($scope.getevents);

          if($scope.events[0].status == 'Error')
          {
             setTimeout(function(){
                  $scope.$apply(function () {
                    $scope.ekeys = 0;
                  });
              });
          }
          else
          {   
              setTimeout(function(){
                $scope.$apply(function () {
                  $scope.ekeys = Object.keys($scope.getevents);
                });
              });
          }
          $scope.opentab(0);
          // console.log($scope.ekeys);  
        });
        $scope.selected = index;
    }
     

      
    $scope.showMeals = function(index) {
      $data.listMeal(currentuser).then(function(res) {
          $scope.meals    = res;
          $scope.org_id   = currentuser.orgId;
          $scope.user_id  = currentuser.userId;
          $scope.getmeals = $scope.meals[0];

          // console.log($scope.getmeals);
          
          if($scope.meals[0].status == 'Error')
          {
              $scope.mkeys = 0;
          }
          else
          {
              $scope.mkeys = Object.keys($scope.getmeals);
          }
          console.log($scope.mkeys);
          $scope.opentab(1);
      });
      $scope.selected = index; 
    };


    $scope.showMydays = function(index) {
        $data.listUserdays(currentuser).then(function(res) {
          $scope.userevents = res[0].events;
          $scope.usermeals = res[0].meals;
          console.log($scope.userevents);

          if($scope.userevents[0].status == 'Error')
          {
              $scope.userekeys = 0;
          }
          else
          {
              $scope.userevents.forEach(function(data) {
                $scope.usereventlist = data;
                $scope.userekeys = Object.keys($scope.usereventlist);
              });
          }
          // console.log($scope.userekeys);

          if($scope.usermeals[0].status == 'Error')
          {
              $scope.usermkeys = 0;
          }
          else
          {
              $scope.usermeals.forEach(function(data) {
                    $scope.usermeallist = data;
                    $scope.usermkeys = Object.keys($scope.usermeallist);
              });
          }

          // $scope.allmydays_events = $scope.userevents;
          // $scope.allmydays_meals = $scope.usermeals;


          $scope.org_id   = currentuser.orgId;
          $scope.user_id  = currentuser.userId;
          // $scope.dkeys    = Object.keys($scope.userdays);
          $scope.opentab(2);
        });
        $scope.selected = index;
    };


      

      $scope.event_detail = function(eventid,date) {

        // console.log(date);

          var currentuser = JSON.parse(localStorage.getItem("current_user"));
          // $scope.eventdetail = single;
          $data.singleEvent(eventid).then(function(res){
              $scope.org_id   = currentuser.orgId;
              $scope.user_id  = currentuser.userId;
              $scope.eventdetail = res[0];
              $scope.curdate  = date;

              // console.log($scope.curdate );
              $scope.mob.pushPage('eventdetail.html',{ animation : 'slide' });
          });     
      };



      $scope.meal_detail = function(mealid,mealday) { 
           // $scope.mealdetail = mealid;
            $data.singleMeal(mealid).then(function(res){
              // $scope.org_id  = userData.org_id;
              // $scope.user_id = userData.user_id;
              $scope.mealdetail = res[0];
              $scope.mealday = mealday;
              $scope.mob.pushPage('mealdetail.html',{ animation : 'slide' });
              // console.log($scope.mealday);
          });
      }

      $scope.joined_eventUser = function(joinuser){
        $data.joinEventUserlist(joinuser).then(function(res){
          $scope.joinuserdetails = res;
          // $scope.org_id  = userData.org_id;
          // $scope.user_id = userData.user_id;
          if(res[0].status == 'Error'){
            $scope.message = res[0].message;
          }
          $scope.mob.pushPage('joineventusers.html',{ animation : 'slide' });
        });
      }
      $scope.joined_mealUser = function(joinuser){
        $data.joinMealUserlist(joinuser).then(function(res){
          $scope.joinmealusers = res;
          // $scope.org_id  = userData.org_id;
          // $scope.user_id = userData.user_id;
          if(res[0].status == 'Error'){
            $scope.message = res[0].message;
          }
          $scope.mob.pushPage('joinmealusers.html',{ animation : 'slide' });
        });
      }

      $scope.join_event = function(joinevent){
      $data.joinEvent(joinevent).then(function(res){
        $scope.joinevents = res;
        // $scope.org_id  = userData.org_id;
        // $scope.user_id = userData.user_id;
        if(res[0].status == 'Success') {
          $scope.message = "You have been successfully joined this event. We Will see you there!";
        }
        else{
          $scope.message = res[0].message;
        }
        // $scope.mob.pushPage('joined.html',{ animation : 'slide'});
        });
      }

      $scope.join_eventdate = function(eventid,dateinfo) {

        var currentuser     = JSON.parse(localStorage.getItem("current_user"));


        $scope.mob.pushPage('recurringevent.html',{ animation : 'slide' });
        // $scope.eventdetail = single;
        $data.listEventDates(eventid,dateinfo).then(function(res) {
            // $scope.listeventdays = res;
            $scope.listeventdays = JSON.parse(JSON.stringify(res));
            $scope.eventid       = eventid;
            $scope.pusharray     = [];

            $scope.daysarr  = [ 'Just Today','Every Sunday', 'Every Monday', 'Every Tuesday', 'Every Wednesday', 'Every Thursday','Every Friday', 'Every Saturday'];
             

            angular.forEach($scope.listeventdays,function(val,key) {
              // console.log($scope.daysarr);
              var eventday =  val.day; 

              if(eventday == 8) {
                  var meetday  = 'Only' +' '+ val.meetup_day +' '+ val.meetup_dates;
                  $scope.daysarr.push(meetday);  
              }
              $scope.pusharray.push({
                      'day'   : $scope.daysarr[eventday],
                      'value' : val.day,
                      'singleday' : dateinfo
              });
            });



            $scope.selectedevents = {
              'radioval' : '8'
            };


            $scope.save_event = function(radioval,event_detail) {
              $scope.evearray = [];
              var reval       = '';
              var singleDate  = '';

              $scope.join_event(event_detail);

              reval = radioval;

              $scope.pusharray.forEach(function(pusharr,i) {
                singleDate = pusharr.singleday;  
              });
                var addevent = {
                  useroption : reval,
                  event_id   : $scope.eventid,
                  singledate : singleDate
                }

                // console.log(addevent);

                $data.addEvent(addevent).then(function(res) {
                    if(res[0].status == 'Success') {
                          $scope.message = "You have been successfully joined this event. We Will see you there!";
                    }
                    else {
                      $scope.message = res[0].message;
                    }
                });
                 $scope.mob.pushPage('home.html',{ animation : 'fade'});
              }

                 

                 $data.selectedEventdates(eventid,dateinfo).then(function(res){
                    $scope.eventsdate = res[0];

                    console.log($scope.eventsdate);

                    angular.forEach($scope.eventsdate,function(useroption) {
                      $scope.selectedoptions = useroption;
                      $scope.selectevents    = $scope.selectedoptions;
                    });

                    // console.log($scope.selectevents);

                    var idx = $scope.selectevents.indexOf($scope.selectedoptions);

                });  
        });    
             
      }


      

       $scope.join_meal = function(joinmeal){
        $data.joinMeal(joinmeal).then(function(res) {
          $scope.joinmeals = res;
          // $scope.org_id  = userData.org_id;
          // $scope.user_id = userData.user_id;
          if(res[0].status == 'Success') {
             $scope.message = "You have been successfully joined this meal event. We Will see you there!";
          }
          else {
             $scope.message = res[0].message;
          }
          // $scope.mob.pushPage('joined.html',{ animation : 'slide' });
        });
      }

      $scope.join_mealdate = function(mealid,mealcurrentday) {
        var currentuser = JSON.parse(localStorage.getItem("current_user"));

        $scope.mob.pushPage('recurringmeal.html',{ animation : 'slide' });
        // $scope.eventdetail = single;
        $data.listMealdates(mealid).then(function(res) {
              $scope.mealtime = res;
              // console.log($scope.mealtime);

              $scope.selectedday = mealcurrentday ;

              $scope.daysarr  = [ 'today','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday'];

              var dayvalue = $scope.daysarr.indexOf($scope.selectedday);
              // console.log(dayvalue);

              function formatDate(date) {
                  var d = new Date(date),
                      month = '' + (d.getMonth() + 1),
                      day = '' + d.getDate(),
                      year = d.getFullYear();

                  if (month.length < 2) month = '0' + month;
                  if (day.length < 2) day = '0' + day;

                  return [year, month, day].join('-');
              }



          $scope.save_meal = function(mealtime,meal_detail) {
              $scope.evearray = [];
              var reval = '';
              var today = new Date();
              var allmeal_date = [];
              var _all_events =[];
              $scope.evearray = [];
              var getdates = '';
              
              $scope.join_meal(meal_detail);

              reval = dayvalue;

              var week_day   = dayvalue; //1
              var currentday = today.getDay()+1; //3

              console.log(week_day);
              console.log(currentday);

              var day_diff =  week_day - currentday ;

                if(day_diff < 0){
                  day_diff += 7;
                }

                var alldates =  today.getTime() + ( 60 * 60 * 24 * 1000 * day_diff);

                _all_events.push(alldates);

                angular.forEach(_all_events,function(ts){
                  for( var i=0 ; i<4 ; i++ ) {
                      var _ts = ts + (60 * 60 * 24 * 1000 * 7 * i );
                      allmeal_date.push(new Date(_ts));
                  }
                   
                });

                $scope.allmealdates = allmeal_date;


                $scope.allmealdates.forEach(function(alldates) {
                  // console.log(alldates);
                  var singleDate = formatDate(alldates); 
                  var i = $scope.evearray.push(singleDate);
                    if(i > 1)
                    {
                        getdates += ',';
                    }                        
                        getdates += singleDate;
                });
                console.log(getdates);

                var addmeal = {
                  useroption : reval,
                  meal_id    : mealid,
                  mealtime   : mealtime,
                  mealdate   : getdates
                }

              // console.log(addmeal);

              $data.addMeal(addmeal).then(function(res){
                // console.log(res);
                  if(res[0].status == 'Success') {
                      $scope.message = "You have been successfully joined this event. We Will see you there!";
                  }
                  else {
                      $scope.message = res[0].message;
                  }
              });
            
              $scope.mob.pushPage('home.html',{ animation : 'fade'});
            }
              $scope.selectmeals = [];

              $data.selectedMealdates(mealid,dayvalue).then(function(res) {
                $scope.mealsdate = res[0];

                angular.forEach($scope.mealsdate, function(useroption) {
                  // console.log(useroption);
                  $scope.selectedoptions = useroption;
                  $scope.selectmeals = $scope.selectedoptions;
                });

                // console.log($scope.selectmeals);

              var idx = $scope.selectmeals.indexOf($scope.selectedoptions);

            }); 
        });    
             
      }
  });
});
 
 module.controller('loginController', function($scope,$data) {
    $('.navbar-fixed-bottom').hide();
 });

 module.controller('MobileController', function($scope,$data) {

    $('.navbar-fixed-bottom').hide();

    // $scope.activetab = 0;
    // $scope.mob.on('postpush',function(event){
    //   if(event.enterPage.page == 'tabs.html')
    //   {
    //     bottomtab.setActiveTab($scope.activetab);
    //   }
    // });

    // $scope.opentab = function(active) {
    //   $scope.activetab = active;
    //   $scope.mob.pushPage('tabs.html',{ animation : 'slide' }); 
    // };

  });


  module.controller('DoSomethingController', function($scope, $data) {

      $('.navbar-fixed-bottom').show();
      var parentevents = $scope.$parent.eventlist;
      $scope.allevents = parentevents;

       var currentuser = JSON.parse(localStorage.getItem("current_user"));

      $data.listUserdays(currentuser).then(function(res) {
          $scope.userevents = res['events'];

          $scope.allmyevents = [];

          angular.forEach($scope.userevents,function(allmyeventdays) {

              angular.forEach(allmyeventdays,function(allmylist) {
                $scope.mydaylist = allmylist[0];
                $scope.allmyevents.push($scope.mydaylist.name, $scope.mydaylist.range_date);
              });
          }); 

      });
  });
  
  module.controller('EatSomethingController', function($scope, $data) {
    $('.navbar-fixed-bottom').show();
      var parentmeals = $scope.$parent.meals;
      $scope.allmeal  = parentmeals;
      var selectedday = '';

       var currentuser = JSON.parse(localStorage.getItem("current_user"));


     $data.listUserdays(currentuser).then(function(res) {
        $scope.usermeals = res['meals'];
        $scope.allmymeals = [];


          angular.forEach($scope.usermeals,function(allmymealdays) {

              angular.forEach(allmymealdays,function(allmylist) {
                
                $scope.mydaylist = allmylist[0];

                var selectedday = $scope.mydaylist.week_day;
                $scope.daysarr  = ['today', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                  $scope.allmymeals.push($scope.mydaylist.name, $scope.daysarr[selectedday]);
              });
          });
      });
  });



  module.controller('MydayController', function($scope, $data) {

    $('.navbar-fixed-bottom').show();

      $scope.myeventdays    = $scope.$parent.userevents;
      $scope.allmyeventdays = $scope.myeventdays[0];

       $scope.mymealdays    = $scope.$parent.usermeals;
      $scope.allmymealdays = $scope.mymealdays[0];


      $scope.isloaded = false;


      $('.events-list-view').show();
      $('.calender-list-view').hide();
      $('.calview').show();
      $('.listview').hide(); 
      var events = [];

      var today = new Date();
      
      $scope.initCalendar = function(){

        angular.forEach($scope.allmyeventdays,function(value) {
          // console.log(value[0]);
            var date = value[0].range_date;
            var d = new Date(date);
            events.push(+new Date(d.getFullYear(), d.getMonth() , d.getDate()));
        });

        var _all_events = [];
        angular.forEach($scope.allmymealdays,function(value) {
          // console.log(value[0].week_day);
          var week_day   = value[0].week_day; //1
          var currentday = today.getDay()+1; //3

          var day_diff =  week_day - currentday ;

          if(day_diff < 0){
            day_diff += 7;
          }


          var alldates =  today.getTime() + ( 60 * 60 * 24 * 1000 * day_diff);

          _all_events.push(alldates);
            //console.log(alldates);
            // var date = value[0].range_date;
            // var d = new Date(date);
            // events.push(+new Date(d.getFullYear(), d.getMonth() , d.getDate()));
        });

        //var _all_days = [];

        angular.forEach(_all_events,function(ts){
        for( var i=0 ; i<4 ; i++ ){
            var _ts = ts + (60 * 60 * 24 * 1000 * 7 * i );
            var d = new Date(_ts);
            events.push(+new Date(d.getFullYear(), d.getMonth() , d.getDate()));
        }
        });
      };


      $scope.initCalendar();

      
      $scope.list_view = function() {
          $('.events-list-view').show();
          $('.calender-list-view').hide();
          $('.calview').show();
          $('.listview').hide();
      }



      

         // $scope.close = function() {
         //    $scope.mob.popPage();
         // }
        var detailinfo = '';
        $scope.myday_detail = '';
         function onChange()
         {
                var eventdate = kendo.toString(this.value(), "yyyy-MM-dd");
                $data.singleMyDay(eventdate).then(function(res){
                    $scope.mydaydetail = res[0];
                    // console.log($scope.mydaydetail);
                    // $scope.mydaykeys   = Object.keys($scope.mydaydetail);
                    $scope.mob.pushPage('mydaydetail.html',{animation : 'lift'}); 
                    window.localStorage.setItem('mydetail', JSON.stringify($scope.mydaydetail));
                });
                $scope.isloaded = true;

                
         }

          var detailinfo          = JSON.parse(localStorage.getItem("mydetail"));
          $scope.myday_detail     = detailinfo;

          if($scope.myday_detail != null)
          {
              $scope.detail_datedinfo = $scope.myday_detail.datedetails;
              console.log($scope.myday_detail);
          }
                
      

      $scope.calender_view = function() {

          $('.events-list-view').hide();
          $('.calender-list-view').show();
          $('.calview').hide();
          $('.listview').show();
          
          $scope.initCalendar(); 

          // if($scope.isloaded == false)
          // {
                $("#calendar").kendoCalendar({
                  value : today,
                  change: onChange,
                  dates : events,
                  month : {
                      // template for dates in month view
                     content: '# if ($.inArray(+data.date, data.dates) != -1) { #' +
                                              '<div class="' +
                                                 '# if (data.value < 10) { #' +
                                                     "exhibition" +
                                                 '# } else if ( data.value < 20 ) { #' +
                                                     "party" +
                                                 '# } else { #' +
                                                     "cocktail" +
                                                 '# } #' +
                                              '">#= data.value #</div>' +
                                           '# } else { #' +
                                           '#= data.value #' +
                                           '# } #'
                  },
                  footer: false
                });
            //   $scope.isloaded = true;
            // }
          }
        
    });


  module.controller('EventController', function($scope, $data) {
      
      $('.navbar-fixed-bottom').show();

      var detailinfo     = $scope.$parent.eventdetail;
      var dateinfo       = $scope.$parent.curdate;
      $scope.singledate  = dateinfo;
      $scope.details     = detailinfo;
      $scope.eventtitle  = detailinfo.event_name;
      $scope.eventid     = detailinfo.id;
  });

  module.controller('MealController', function($scope, $data) {
    $('.navbar-fixed-bottom').show();
      var mealinfo       = $scope.$parent.mealdetail;
      $scope.meal_detail = mealinfo;
      $scope.mealtitle   = mealinfo.meal_type;
      $scope.mealcurrentday = $scope.$parent.mealday;
  });

  module.controller('JoinEventUsersController',function($scope,$data){

    $('.navbar-fixed-bottom').show();

      var joined_userinfo = $scope.$parent.joinuserdetails;
      $scope.joinedusers  = joined_userinfo;

      var detailinfo     = $scope.$parent.eventdetail;
      $scope.details     = detailinfo;
      console.log(joined_userinfo);
  });

  module.controller('JoinMealUsersController',function($scope,$data){

    $('.navbar-fixed-bottom').show();
      var joined_mealuserinfo   = $scope.$parent.joinmealusers;
      $scope.joined_mealusers   = joined_mealuserinfo;

      var mealinfo       = $scope.$parent.mealdetail;
      $scope.meal_detail = mealinfo;
    
  });

  module.controller('recurringController',function($scope,$data) {
    $('.navbar-fixed-bottom').show();

    var detailinfo     = $scope.$parent.eventdetail;
    $scope.details     = detailinfo;
    // $scope.joined = function(){
    //   $scope.mob.pushPage('recurringevent.html',{ animation : 'slide' });
    // }
  });

  module.controller('recurringmealController',function($scope,$data) {

    $('.navbar-fixed-bottom').show();

    var mealinfo       = $scope.$parent.mealdetail;
    $scope.meal_detail = mealinfo;
    // $scope.joined = function(){
    //   $scope.mob.pushPage('recurringevent.html',{ animation : 'slide' });
    // }
  });
  

  module.controller('JoinedController',function($scope,$data){
    $scope.item = $data.selectedItem;
  });


  module.factory('$data',function($http) {

      var data = {};
      // var apiUrl = 'http://67.227.228.88/~development002/community/index.php/api';
      var apiUrl = 'http://www.yourday.io/index.php/api';

      data.getUserInfo = function(user_uuid){
         var getUsers = $http.get(apiUrl +'?func=getAppUser&sec_token=YHDgjy9Q7yuDFgTE&uuid='+user_uuid).then(function(response){
          return response.data;
        });
        return getUsers;
      }

      data.listEvents = function(currentuser){
        var events = $http.get(apiUrl +'?func=listEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId).then(function(response){
           // console.log(response.data);
          return response.data;
        });
        return events;
      }

      data.listMeal = function(currentuser){
        var meals = $http.get(apiUrl +'?func=listMeal&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId).then(function(response){
          //console.log(response.data);
          return response.data;
        });
        return meals;
      }

      data.listUserdays = function(currentuser) {
        var myday = $http.get(apiUrl + '?func=listUserdays&sec_token=YHDgjy9Q7yuDFgTE&user_id='+currentuser.userId).then(function(response){
          // console.log(response.data);
          return response.data;
        });
        return myday;
      }
      data.listEventDates = function(singleevent,singledate){
        var myday = $http.get(apiUrl + '?func=listEventDates&sec_token=YHDgjy9Q7yuDFgTE&event_id='+singleevent+'&singledate='+singledate).then(function(response){
          console.log(response.data);
          return response.data;
        });
        return myday;
      }

      data.listMealdates = function(singlemeal){
        var myday = $http.get(apiUrl + '?func=listMealDates&sec_token=YHDgjy9Q7yuDFgTE&plan_meal_id='+singlemeal).then(function(response){
          console.log(response.data);
          return response.data;
        });
        return myday;
      }

      data.addEvent = function(addevent){
        var currentuser = JSON.parse(localStorage.getItem("current_user")); 
        var add_event = $http.get(apiUrl + '?func=addEventrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+addevent.useroption+'&id='+addevent.event_id+'&singledate='+addevent.singledate+'&user_id='+currentuser.userId).then(function(response){
          // console.log(response.data);
          return response.data;
        });
        return add_event;
      }

      data.addMeal = function(addmeal) {
        var currentuser = JSON.parse(localStorage.getItem("current_user")); 
        var add_meal = $http.get(apiUrl + '?func=addMealrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+addmeal.useroption+'&meal_time='+addmeal.mealtime+'&id='+addmeal.meal_id+'&meal_date='+addmeal.mealdate+'&user_id='+currentuser.userId).then(function(response){
          // console.log(response.data);
          return response.data;
        });
        return add_meal;
      }

      data.selectedEventdates = function(selecteventid,singledate) {
        var currentuser   = JSON.parse(localStorage.getItem("current_user")); 
        var selected_meal = $http.get(apiUrl + '?func=selectedEventRange&sec_token=YHDgjy9Q7yuDFgTE&id='+selecteventid+'&eventdate='+singledate+'&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return selected_meal;
      }

      data.selectedMealdates = function(selecteventid,weekday) {
        var currentuser   = JSON.parse(localStorage.getItem("current_user")); 
        var selected_meal = $http.get(apiUrl + '?func=selectedMealRange&sec_token=YHDgjy9Q7yuDFgTE&id='+selecteventid+'&week_day='+weekday+'&user_id='+currentuser.userId).then(function(response){
          // console.log(response.data);
          return response.data;
        });
        return selected_meal;
      }

      data.singleEvent = function(singleevent){
        var currentuser = JSON.parse(localStorage.getItem("current_user")); 
        var single = $http.get(apiUrl +'?func=singleEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+singleevent.id).then(function(response){
          // console.log(response.data);
          return response.data;
        });
        return single;
      }
       data.singleMeal = function(singlemeal){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var singleMeal = $http.get(apiUrl +'?func=singleMeal&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+singlemeal.id).then(function(response){
          //console.log(response.data);
          return response.data;
        });
        return singleMeal;
      }

      data.singleMyDay = function(singledate){
        var currentuser = JSON.parse(localStorage.getItem("current_user")); 
        var singleday = $http.get(apiUrl +'?func=singleMyDay&sec_token=YHDgjy9Q7yuDFgTE&user_id='+currentuser.userId+'&eventdate='+singledate).then(function(response){
          // console.log(response.data);
          return response.data;
        });
        return singleday;
      }

      data.joinEventUserlist = function(joineventuser){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinEvent = $http.get(apiUrl + '?func=joinEventUserList&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joineventuser.id).then(function(response){
          //console.log(response.data);
          return response.data;
        });
        return joinEvent;
      }

      data.joinMealUserlist = function(joinmealuser){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinMeal = $http.get(apiUrl + '?func=joinMealUserList&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joinmealuser.id).then(function(response){
          //console.log(response.data);
          return response.data;
        });
        return joinMeal;
      }

      data.joinEvent = function(joinevent){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinevent = $http.get(apiUrl + '?func=joinEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joinevent.id+'&user_id='+currentuser.userId).then(function(response){
          //console.log(response.data);
          return response.data;
        });
        return joinevent;
      }

      data.joinMeal = function(joinmeal){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinmeal = $http.get(apiUrl + '?func=joinMeal&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joinmeal.id+'&user_id='+currentuser.userId).then(function(response){
          //console.log(response.data);
          return response.data;
        });
        return joinmeal;
      }

      return data;
  });


})();