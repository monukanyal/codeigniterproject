(function(){
  'use strict';
  var module = angular.module('app', ['onsen']);
  module.directive('phoneNumber', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, el, atts, ngModel){
        /* called when model is changed from the input element */
        ngModel.$parsers.unshift(function(viewValue){
          var numbers = viewValue.replace(/\D/g, ''),
              char = {0:'(',3:')-',6:' - '};
          numbers = numbers.slice(0, 10);
          viewValue = '';
          for (var i = 0; i < numbers.length; i++) {
            viewValue += (char[i]||'') + numbers[i];
          }
          
          el.val(viewValue);
          
          return viewValue;
        });

        /* called when model is changed outside of the input element */
        ngModel.$formatters.push(function(modelValue) {
          return modelValue; 
        });
        
        /* called when the model changes, if validation fails the model value won't be assigned */
        ngModel.$validators.phone = function(modelValue, viewValue) {
          if (modelValue) {
            return modelValue.match(/\d/g).length === 10; 
          } else {
            return false;
          }
        }
      }
     }
  });


  module.controller('MainController', function($scope,$data){
    $scope.appUrl = 'http://www.yourday.io/';
    ons.ready(function(){
      var isAppForeground = true;

      /** disable device back button **/
      ons.disableDeviceBackButtonHandler();
      document.addEventListener('backbutton', function () {}, false);
     
      /** cordova-plugin-contacts-phonenumbers **/
      navigator.contactsPhoneNumbers.list(function(contacts) {
        var arr = [];
        for(var i = 0; i < contacts.length; i++) {
          // console.log(contacts[i].id + " - " + contacts[i].firstName+" "+contacts[i].lastName);
          for(var j = 0; j < contacts[i].phoneNumbers.length; j++) {
            var phone = contacts[i].phoneNumbers[j];
            // console.log("Contacts ===> " + phone.type + "  " + phone.number + " (" + phone.normalizedNumber+ ")");
            arr.push({id: contacts[i].id,firstName: contacts[i].firstName ,lastName: contacts[i].lastName,number : phone.number});
          }
        }
        $scope.contacts = arr;
        $scope.selectedContact = "{}";
      },
      function(error) {
        console.error(error);
      });

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

    $scope.chkloginUser = function(){
      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      // console.log("Current User Check :"+JSON.stringify(currentuser));

      if(currentuser != '' || currentuser != null || currentuser != undefined)
      {
        $scope.care_name = currentuser.username;
        var login_current_user = JSON.stringify(currentuser);
        var userid = currentuser.userId;
        var careId = currentuser.careId;
        var orgId = currentuser.orgId;
        var userRole = currentuser.role;
        var loggedId;
        $scope.userRole = currentuser.role;

        $data.getloginedUser(userid).then(function(res){
          // console.log("Response getloginedUser :"+JSON.stringify(res));
          if(res[0].status == 'Success'  && currentuser.role == 'resident' ) 
          {
            modal.hide();
            $scope.mob.pushPage('home.html',{ animation : 'fade' });
          }
          else if(res[0].status == 'Success' && currentuser.role == 'child'){
            modal.hide();
            var form_data = {
              func : 'care_belongs_to',
              sec_token : 'YHDgjy9Q7yuDFgTE',
              care_id : careId,
              org_id  :  orgId
            };
              
            // console.log("Form Data getloginedUser :"+JSON.stringify(form_data));

            $.ajax({
              type: 'Get',
              data: form_data,
              url: "http://www.yourday.io/index.php/api",
              success: function(res){
                modal.hide();
                // console.log("Response care_belongs_to :"+JSON.stringify(res));
                var resident_detail=res.resident_details;
                $scope.resident_details = res.resident_details;
                window.localStorage.setItem('resident_details',JSON.stringify(resident_detail));
                setTimeout(function(){
                  $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
                },1500);
              },
              error: function(error){
                modal.hide();
                var err = "Error :"+JSON.stringify(error);
                ons.notification.alert({
                  message: err
                });
              }
            });   
          }
          else {
            ons.notification.alert({
              message: "User does not exist any more",
              title: "Error",
              buttonLabel: "OK"
            });
            $scope.mob.pushPage('auth.html',{ animation : 'fade' });
            modal.hide();
          }
        });
      }
    }

      var phone = '' , loginUser;
      $scope.manual_login = function(phonenum){
        modal.show();
        $scope.phonenumber = phonenum;
        phone =  $scope.phonenumber;
        var user = "resident";
        $scope.loginUser = user;
        loginUser = $scope.loginUser;
        $scope.userRole ="resident";

        $data.getUserLogin(phone,user).then(function(res){ 
          modal.hide();
          // console.log("Response :"+JSON.stringify(res));
          if( res.status == "Success")
          {
            var userlogin =  {
              userId   : res.user_id,
              orgId    : res.org_id,
              username : res.username,
              role     : res.user,
              mobile   : res.mobile
            }

            window.localStorage.setItem('current_user', JSON.stringify(userlogin));
            $scope.mob.pushPage('home.html',{ animation : 'fade' });
            setTimeout(function(){
              location.reload(true);
            },1000);
          }
          else 
          {
            $scope.msgerror = "Phone number doesn't exists";
            $scope.mob.pushPage('manuallogin.html',{ animation : 'fade' });
          }
        });
      }     

      $scope.child_manual_login = function(phonenum){
        modal.show();
        $scope.phonenumber = phonenum;
        phone =  $scope.phonenumber;
        var user = "child";
        $scope.loginUser = user;
        loginUser = $scope.loginUser;
        $scope.userRole ="child";

        $data.getUserLogin(phone,user).then(function(res){ 
          modal.hide();
          // console.log("Response child_manual_login :"+JSON.stringify(res));
          if(res.status == "Success")
          {
            var childuserlogin =  {
              userId   : res.user_id,
              careId   : res.care_id,
              orgId    : res.org_id,
              username : res.username,
              role     : res.user,
              mobile   : res.mobile,
              resident_mobile : res.resident_mobile
            };

            window.localStorage.setItem('current_user', JSON.stringify(childuserlogin));
            var currentuser = JSON.parse(localStorage.getItem("current_user"));
            // console.log("Current User child_manual_login :"+JSON.stringify(currentuser));

            $scope.care_name = res.username;
            
            $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
            setTimeout(function(){
              location.reload(true);
            },1000);

            // if(res.registration_status == 0)
            // {
            //   $scope.resident_mobile = res.resident_mobile;
            //   $scope.care_mobile = res.mobile;
            //   $scope.registration_status = res.registration_status;
            //   $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
            // }
            // else if(res.registration_status == 1)
            // {
            //   // $scope.care_subscription_check();
            //   $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
            // }
            // else{
            //   // $scope.care_subscription_check();
            //   $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
            // }
          }
          else{
            window.localStorage.setItem('care_phone', phonenum);
            ons.notification.alert({
              message: 'Number does not match care account !',
              title: 'Care Account',
              buttonLabel: 'OK',
              animation: 'default'
            });
            setTimeout(function(){
              $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
            }, 2000);
          }
        });
      }

      $scope.care_subscription_check = function(){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        // console.log("Current User :"+JSON.stringify(currentuser));
        var careId = currentuser.careId;

        var form_data = {
          care_id : careId
        };

        $.ajax({
          type: 'POST',
          data: form_data,
          url: "http://www.yourday.io/index.php/Paynow/care_subscription_check",
          success: function(response){
            modal.hide();
            var res = JSON.parse(response);
                   
            // console.log("Response care_subscription_check :"+JSON.stringify(res));
            if(res.subscription_status == 'active')
            {
              ons.notification.alert({
                message: res.text
              });
              var subscriptionId = res.result;
              window.localStorage.setItem('subscriptionId', subscriptionId);
              var orgId = currentuser.orgId;
              var careId = currentuser.careId;
              var form_data = {
                func : 'care_belongs_to',
                sec_token : 'YHDgjy9Q7yuDFgTE',
                care_id : careId,
                org_id  :  orgId
              };
          
              $.ajax({
                type: 'Get',
                data: form_data,
                url: "http://www.yourday.io/index.php/api",
                success: function(res){
                  modal.hide();
                  var resident_details=res.resident_details;
                  $scope.resident_details = res.resident_details;
                  window.localStorage.setItem('resident_details',JSON.stringify(resident_details));
                  // console.log("Response :"+JSON.stringify(resident_details));
                  setTimeout(function(){
                    $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
                  });
                  setTimeout(function(){
                    location.reload(true);
                  },2000);
                },
                error: function(error){
                  modal.hide();
                  var err = "Error :"+JSON.stringify(error);
                  ons.notification.alert({
                    message: err
                  });
                }
              });
            }
            else if(res.subscription_status == 'suspended' || res.subscription_status == 'expired')
            {
              ons.notification.alert({
                message: "Resident Viewer Requires Pro account"/**res.text**/
              });
              var subscriptionId = res.result;
              window.localStorage.setItem('subscriptionId', subscriptionId);

              setTimeout(function(){
                $scope.mob.pushPage('creditPage.html',{ animation : 'fade' });
              },1000);
            }
            else if(res.subscription_status == 'no_subscription')
            {
              ons.notification.alert({
                message: res.text
              });
              setTimeout(function(){
                $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
              },1000);
            }
            else{
              ons.notification.alert({
                message: res.text
              });
              setTimeout(function(){
                $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
              },1000);
            } 
          },
          error: function(error){
            modal.hide();
            var err = "Error :"+JSON.stringify(error);
            ons.notification.alert({
              message: err
            });
            setTimeout(function(){
              $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
            },1000);
          }
        });
      }

      $scope.care_belongs_to=function(resident_id){
        newmodal.show();
        var residentId= resident_id;
        window.localStorage.setItem('resident_id', residentId);
        // console.log("Current resident Inside :"+resident_id); 
        setTimeout(function(){
          newmodal.hide();
          $scope.mob.pushPage('schedule.html',{ animation : 'fade' });
        }, 2000);
      }

      // $scope.care_belongs_to = function(resident_id){
      //   newmodal.show();
      //   var residentId= resident_id;
      //   window.localStorage.setItem('resident_id', residentId);
      //   // console.log("Current resident Inside :"+resident_id);

      //   var currentuser = JSON.parse(localStorage.getItem("current_user"));
      //   var careId = currentuser.userId;

      //   var form_data = {
      //     care_id : careId
      //   };

      //   $.ajax({
      //     type: 'POST',
      //     data: form_data,
      //     url: "http://www.yourday.io/index.php/Paynow/care_subscription_check",
      //     success: function(response){
      //       newmodal.hide();
      //       var res = JSON.parse(response);
      //       console.log("Response care_subscription_check :"+JSON.stringify(response));

      //       if(res.subscription_status == 'active')
      //       {
      //         ons.notification.alert({
      //           message: res.text
      //         });
      //         var subscriptionId = res.result;
      //         window.localStorage.setItem('subscriptionId', subscriptionId);
              
      //         setTimeout(function(){
      //           $scope.mob.pushPage('schedule.html',{ animation : 'fade' });
      //         }, 2000);
      //       }
      //       else if(res.subscription_status == 'suspended' || res.subscription_status == 'expired')
      //       {
      //         ons.notification.alert({
      //           message: res.text
      //         });
      //         var subscriptionId = res.result;
      //         window.localStorage.setItem('subscriptionId', subscriptionId);

      //         setTimeout(function(){
      //           $scope.mob.pushPage('creditPage.html',{ animation : 'fade' });
      //         },1000);
      //       }
      //       else if(res.subscription_status == 'no_subscription')
      //       {
      //         ons.notification.alert({
      //           message: res.text
      //         });
      //         setTimeout(function(){
      //           $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
      //         },1000);
      //       }
      //       else{
      //         ons.notification.alert({
      //           message: res.text
      //         });
      //         setTimeout(function(){
      //           $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
      //         },1000);
      //       } 
      //     },
      //     error: function(error){
      //       newmodal.hide();
      //       var err = "Error :"+JSON.stringify(error);
      //       ons.notification.alert({
      //         message: err
      //       });
      //       setTimeout(function(){
      //         $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
      //       },1000);
      //     }
      //   });
      // }

      $scope.careRegister = function(form){
        modal.show();
        /** Personal Details **/
        var firstname = form.firstname;
        var lastname = form.lastname;
        var mobileNumber = form.mobile;
        var email = form.email;
        var gender = form.gender;
        var resident = form.resident;
        
        // console.log("registration_status careRegister :"+$scope.registration_status);

        if($scope.registration_status == 1)
        {
          ons.notification.alert({
            message: "Care Already Registered !!!"
          });
        }
        else if($scope.registration_status == 0)
        {
          var form_data = {
            func : 'update_child_account',
            sec_token : 'YHDgjy9Q7yuDFgTE',
            first_name : firstname,
            last_name : lastname,
            mobile : mobileNumber,
            email : email,
            gender : gender,
            resident_mobile : resident
          };
        }
        else
        {
          var form_data = {
            func : 'create_child_account',
            sec_token : 'YHDgjy9Q7yuDFgTE',
            first_name : firstname,
            last_name : lastname,
            mobile : mobileNumber,
            email : email,
            gender : gender,
            resident_mobile : resident
          };
        }

        // console.log("Form Data careRegister :"+JSON.stringify(form_data));

        $.ajax({
          type: 'GET',
          data: form_data,
          url: "http://www.yourday.io/index.php/api",
          success: function(response){
            modal.hide();
            // console.log("Response Care Register :"+JSON.stringify(response));
            var childuserlogin =  {
              userId   : response.resident_id,
              careId   : response.care_id,
              orgId    : response.admin_id,
              role     : 'child'
            }

            window.localStorage.setItem('current_user', JSON.stringify(childuserlogin));
            
            ons.notification.alert({
              message: response.message
            });

            if( response.status == "success")
            {
              $scope.register_firstname = firstname ;
              $scope.register_lastname = lastname ;

              setTimeout(function(){
                $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
              },1000);
            }
            else if( response.status == "error")
            {
              setTimeout(function(){
                $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
              },1000);
            }
            else{
              setTimeout(function(){
                $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
              },1000);
            }
          },
          error: function(error){
            modal.hide();
            var err = "Error :"+JSON.stringify(error);
            // console.log(err);
            // ons.notification.alert({
            //   message: err
            // });
            setTimeout(function(){
              $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
            },1000);
          }
        });
      }

      $scope.previousPage=function(){
        $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
      }

      $scope.careAccountPay = function(form){
        /** Personal Details **/
        var firstname = form.firstname;
        var lastname = form.lastname;
        var address = form.address;
        var city = form.city;
        var state = form.state;
        var country = form.country;
        var zip = form.zip;
        
        /** Card Details **/
        var cardnumber = form.card_num;
        var exp_month = form.month;
        var exp_year = form.year;
        var exp_date = exp_year+"-"+exp_month;
        
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var  care_id = currentuser.careId;
        // console.log("Current Care Inside :"+care_id); 
        
        var form_data = {
          care_id : care_id,
          firstname : firstname,
          lastname : lastname,
          cardnum : cardnumber,
          exp_date : exp_date,
          address : address,
          city : city,
          state : state,
          zipcode : zip
        };

        // console.log("Form Data :"+JSON.stringify(form_data));
        
        modal.show();
        $.ajax({
          type: 'POST',
          data: form_data,
          url: "http://www.yourday.io/index.php/Paynow/create_subscription", /** create_subscription_dummy **/
          success: function(response){
            modal.hide();
            var res = JSON.parse(response);
            // console.log("Response create_subscription :"+JSON.stringify(res));
            ons.notification.alert({
              message: res.text
            });

            var username = firstname+" "+lastname;
            // console.log("Status :"+res.status);

            if(res.status == "success")
            {
              // console.log("User name :"+username);
              $scope.care_name = username;
              window.localStorage.setItem('subscriptionId', res.result);
              $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
              setTimeout(function(){
                location.reload(true);
              },2000);
            }
            else if(res.status == "error")
            {
              setTimeout(function(){
                $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
              },1000);
            }
            else{
              setTimeout(function(){
                $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
              },1000);
            }
          },
          error: function(error){
            modal.hide();
            var err = "Error :"+JSON.stringify(error);
            // ons.notification.alert({
            //   message: err
            // });
            // console.log("Response Error :"+JSON.stringify(err));

            setTimeout(function(){
              $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
            },1000);
          }
        });
      }

      $scope.careAccountEdit = function(form){
        // modal.show();

        /** Form Details **/
        var cardnum = form.cardnum;
        var exp_month = form.month;
        var exp_year = form.year;
        var exp_date = exp_year+"-"+exp_month;
        var subscriptionId = JSON.parse(localStorage.getItem("subscriptionId"));
        // console.log("subscriptionId :"+subscriptionId);

        var form_data = {
          cardnum : cardnum,
          exp_date : exp_date,
          subscriptionId : subscriptionId
        };

        $.ajax({
          type: 'POST',
          data: form_data,
          url: "http://www.yourday.io/index.php/Paynow/update_subscription",
          success: function(response){
            modal.hide();
            var res = JSON.parse(response);
            // console.log("Success Text :"+JSON.stringify(res));
            ons.notification.alert({
              message: res.text
            });
            setTimeout(function(){
              $scope.chkloginUser(); 
            },1000);
          },
          error: function(error){
            modal.hide();
            var err = "Error :"+JSON.stringify(error);
            alert(JSON.stringify(err));
            ons.notification.alert({
              message: err
            });
          }
        });
      }

      $scope.careAccountUnsubscribe = function(){
        modal.show();
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        // console.log("Current User Under Unsubscribe :"+JSON.stringify(currentuser));
        var careId = currentuser.careId; 
        // console.log("Care ID :"+careId);
        
        var subscriptionId = JSON.parse(localStorage.getItem("subscriptionId"));
        // console.log("subscriptionId :"+subscriptionId);
        
        var form_data = {
          care_id : careId,
          subscriptionId : subscriptionId
        };

        $.ajax({
          type: 'POST',
          data: form_data,
          url: "http://www.yourday.io/index.php/Paynow/cancel_subscription",
          success: function(response){
            modal.hide();
            var res = JSON.parse(response);
            // console.log("Success Text :"+res.text);
            ons.notification.alert({
              message: res.text
            });
            // localStorage.removeItem(subscriptionId);
            window.localStorage.setItem('subscriptionId', '');
            setTimeout(function(){
              $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
            },1000);
          },
          error: function(error){
            modal.hide();
            var err = "Error :"+JSON.stringify(error);
            ons.notification.alert({
              message: err
            });
            setTimeout(function(){
              $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
            },1000);
          }
        });
      }

      $scope.resident_schedule = function(){
        newmodal.show();
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        // console.log("Current User :"+JSON.stringify(currentuser));
        if(currentuser != null)
        {
          $scope.mob.pushPage('schedule.html',{ animation : 'fade'}); 
          var care_id = currentuser.careId;

          var form_data = {
            func : 'care_approval_check',
            sec_token : 'YHDgjy9Q7yuDFgTE',
            care_id : care_id
          };

          // console.log("Form Data :"+JSON.stringify(form_data));

          $.ajax({
            type: 'GET',
            data: form_data,
            url: "http://www.yourday.io/index.php/api",
            success: function(response){
              // console.log("Response Care Approval :"+JSON.stringify(response));
              if(response.response == 1)
              {
                var currentuser = JSON.parse(localStorage.getItem("current_user"));
                // console.log("Current User care_approval_check :"+JSON.stringify(currentuser));
                var careId = currentuser.careId;
                $scope.resident_mobile = currentuser.resident_mobile;
                $scope.care_mobile = currentuser.mobile;
                
                var form_data = {
                  care_id : careId
                };

                $.ajax({
                  type: 'POST',
                  data: form_data,
                  url: "http://www.yourday.io/index.php/Paynow/care_subscription_check",
                  success: function(response){
                    newmodal.hide();
                    var res = JSON.parse(response);
                    // console.log("Response care_subscription_check :"+JSON.stringify(response));
                    $scope.registration_status = res.registration_status;

                    if(res.subscription_status == 'active')
                    {
                      ons.notification.alert({
                        message: res.text
                      });
                      var subscriptionId = res.result;
                      window.localStorage.setItem('subscriptionId', subscriptionId);
                      
                      setTimeout(function(){
                        $scope.mob.pushPage('mydaychild.html',{ animation : 'fade'});
                      }, 500);
                    }
                    else if(res.subscription_status == 'suspended' || res.subscription_status == 'expired')
                    {
                      ons.notification.alert({
                        message: res.text
                      });
                      var subscriptionId = res.result;
                      window.localStorage.setItem('subscriptionId', subscriptionId);

                      setTimeout(function(){
                        $scope.mob.pushPage('creditPage.html',{ animation : 'fade' });
                      },500);
                    }
                    else if(res.subscription_status == 'no_subscription')
                    {
                      ons.notification.alert({
                        message: res.text
                      });
                      if(res.registration_status == 1){
                        setTimeout(function(){
                          $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
                        },500);
                      }
                      else if(res.registration_status == 0){
                        setTimeout(function(){
                          $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
                        },500);
                      }
                      else {
                        setTimeout(function(){
                          $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
                        },500);
                      }
                    }
                    else{
                      ons.notification.alert({
                        message: res.text
                      });

                      if(res.registration_status == 1){
                        setTimeout(function(){
                          $scope.mob.pushPage('carePay.html',{ animation : 'fade' });
                        },1000);
                      }
                      else if(res.registration_status == 0){
                        setTimeout(function(){
                          $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
                        },1000);
                      }
                      else {
                        setTimeout(function(){
                          $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
                        },1000);
                      }
                    } 
                  },
                  error: function(error){
                    newmodal.hide();
                    var err = "Error :"+JSON.stringify(error);
                    ons.notification.alert({
                      message: err
                    });
                    setTimeout(function(){
                      $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
                    },500);
                  }
                });
              }
              else if(response.response == 0){
                newmodal.hide();
                ons.notification.alert({
                  message: response.message
                });
                $scope.mob.pushPage('schedule.html',{ animation : 'fade'});
              }
            },
            error: function(error){
              modal.hide();
              var err = "Error :"+JSON.stringify(error);
              ons.notification.alert({
                message: err
              });
              $scope.mob.pushPage('schedule.html',{ animation : 'fade'}); 
            }
          });         
        }
        else{
          ons.notification.alert({
            message: 'You Are Not Subscribed , Please Continue to Register !',
            title: 'Subscribe',
            buttonLabel: 'OK',
            animation: 'default'
          });
          setTimeout(function(){
            $scope.mob.pushPage('careRegister_after.html',{ animation : 'fade'});
          },1000);
        }
      }

      $scope.care_register = function(){
        $scope.mob.pushPage('careRegister.html',{ animation : 'fade'});
      }

      $scope.go_site_calendar = function(){
        var siteCode = localStorage.getItem("site_code");
        if(siteCode == '' || siteCode == null || siteCode == undefined)
        {
          $scope.mob.pushPage('calendar.html',{ animation : 'fade'});
        }
        else{
          $scope.hide_subscription = true;
          newmodal.show();
          setTimeout(function(){
            newmodal.hide();
            $scope.mob.pushPage('schedule.html',{ animation : 'fade'});
          },2000);
        }
      }

      $scope.getResidents = function(admin){
        modal.show();
        var admin_id = admin ;
        var form_data = {
          func : 'list_resident_admin',
          sec_token : 'YHDgjy9Q7yuDFgTE',
          admin_id : admin_id
        };
        
        $.ajax({
          type: 'GET',
          data: form_data,
          url: "http://www.yourday.io/index.php/api",
          success: function(response){
            modal.hide();
            $scope.list_resident_admin = response;
            $scope.mob.pushPage('careRegister.html',{ animation : 'fade'}); 
          },
          error: function(error){
            modal.hide();
            var err = "Error :"+JSON.stringify(error);
            ons.notification.alert({
              message: err
            });
            $scope.mob.pushPage('careRegister.html',{ animation : 'fade'}); 
          }
        });
      }

      $scope.site_schedule = function(){
        $scope.mob.pushPage('schedule_dosomething.html',{ animation : 'fade'});
      }

      $scope.site_code_verify = function(site_code){
        window.localStorage.setItem('site_code', site_code);
        $scope.hide_subscription=true;
        newmodal.show();
        setTimeout(function(){
          newmodal.hide();
          $scope.mob.pushPage('schedule.html',{ animation : 'fade'});
        },2000);
      }


      $scope.appdata = {};
      $scope.appdata.selected = 0;
      $scope.appdata.getevents = {};
      $scope.appdata.events = {};
      $scope.appdata.ekeys = 0;
      $scope.appdata.meals = {};
      $scope.appdata.getmeals = {};
      $scope.appdata.mkeys = 0;
      $scope.appdata.userevents = {};
      $scope.appdata.usermeals  = {};
      $scope.appdata.userekeys  = 0;
      $scope.appdata.usereventlist = {};
      $scope.appdata.usermkeys = 0;
      $scope.appdata.usermeallist = {};
      var show_userevent = false;

      $scope.open_child_login = function(){
        var care_phone = localStorage.getItem("care_phone");
        var siteCode = localStorage.getItem("site_code");
        // console.log("Care Phone :"+care_phone);
        // console.log("Site Code :"+siteCode);
        if(care_phone != null){
          $scope.child_manual_login(care_phone);  
        }
        else{
          if(siteCode == '' || siteCode == null || siteCode == undefined)
          {
            $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
          }
          else{
            $scope.hide_subscription = true;
            newmodal.show();
            setTimeout(function(){
              newmodal.hide();
              $scope.mob.pushPage('schedule.html',{ animation : 'fade'});
            },2000);
          }
        }
        
        // if(siteCode == '' || siteCode == null || siteCode == undefined)
        // {
        //   $scope.mob.pushPage('calendar.html',{ animation : 'fade'});
        // }
        // else{
        //   $scope.hide_subscription = true;
        //   newmodal.show();
        //   setTimeout(function(){
        //     newmodal.hide();
        //     $scope.mob.pushPage('schedule.html',{ animation : 'fade'});
        //   },2000);
        // }
      } 

      $scope.auth_page = function(){
        $scope.mob.pushPage('auth.html',{ animation : 'fade' });
      } 
      
      $scope.app_sendSms = function() {
        modal.show();
        $scope.autologin = false;
                
        // Send Sms //
        var number = '+15125663933'; // 15125663933(old) 18888209850(new)
        var message = 'This is a test message of the emergency system.Testing function {'+uniqueid+'} to ensure alerting is working please press send now';
        // CONFIGURATION //
        var intent = 'INTENT'; // INTENT
    
        var success = function (){
          $scope.autologin = true;
          // console.log("Success");
          setTimeout(function(){
            modal.hide();
            // console.log("Set Time Out 5 sec");
            $scope.direct_login(uniqueid);
          },5000);
        };

        var error = function(e){
          modal.hide();
          alert('Error :'+e);
          setTimeout(function(){
            // console.log("Set Time Out 1 sec");
            $scope.mob.pushPage('manuallogin.html',{ animation : 'fade' });
          },1000);
        };
    
        sms.send(number, message, intent, success, error);

        setTimeout(function(){
          modal.hide();
          // console.log("Timer 3 Sec");
          $scope.mob.pushPage('manuallogin.html',{ animation : 'fade'});
          // var test_uniqueid = "4xC23";
          // $scope.direct_login(test_uniqueid);
        },3000);
      }

      $scope.app_child_sendSms = function() {
        modal.show();
        $scope.autologin = false;
                
        // Send Sms //
        var number = '+15125663933'; // 15125663933(old) 18888209850(new)
        var message = 'This is a test message of the emergency system.Testing function {'+uniqueid+'} to ensure alerting is working please press send now';
        // CONFIGURATION //
        var intent = ''; // INTENT
    
        var success = function (){
          $scope.autologin = true;
          // console.log("Success");
          setTimeout(function(){
            modal.hide();
            // console.log("Set Time Out 5 sec");
            $scope.direct_child_login(uniqueid);
          },5000);
        };

        var error = function(e){
          modal.hide();
          alert('Error :'+e);
          setTimeout(function(){
            // console.log("Set Time Out 1 sec");
            $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade' });
          },1000);
        };
    
        sms.send(number, message, intent, success, error);

        setTimeout(function(){
          modal.hide();
          // console.log("Timer 3 Sec");
          $scope.mob.pushPage('childManualLogin.html',{ animation : 'fade'});
          // var test_uniqueid = '8xD06'; /* Salma */
          // $scope.direct_child_login(test_uniqueid);
        },3000);
      }
              
      /** Custom 27-01-2017 **/
      $scope.direct_login = function(uniqueid){
        $data.getCustomUserLogin(uniqueid).then(function(res){
          // console.log("Response :"+res);
          if(res.status == 'Success' && res.user == 'resident')
          {
            modal.hide();
            var userlogin =  {
              userId   : res.user_id,
              orgId    : res.org_id,
              username : res.username,
              role     : res.user,
              mobile   : res.mobile
            }
            window.localStorage.setItem('current_user', JSON.stringify(userlogin));
            $scope.mob.pushPage('home.html',{ animation : 'fade' });
            setTimeout(function(){
              location.reload(true);
            },100);
          }
          else if(res.status == 'Success' && res.user == 'child'){
            modal.hide();
            var childuserlogin = {
              userId   : res.user_id,
              orgId    : res.org_id,
              username : res.username,
              role     : res.user,
              mobile   : res.mobile
            }
            window.localStorage.setItem('current_user', JSON.stringify(childuserlogin));
            
            $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
            setTimeout(function(){
              location.reload(true);
            },100);
          }
          else if(res.status == 'Success' && res.user == 'undefined') {
            modal.hide();
            $scope.usrerror = "Please select user role";
          }
          else {
            modal.hide();
            $scope.msgerror = res.message;
          }
        });
      }
     
      $scope.direct_child_login = function(uniqueid){
        modal.show();
        // console.log("uniqueid :"+uniqueid);
        $data.getCustomUserLogin(uniqueid).then(function(res){
          // console.log("Response direct_child_login :"+JSON.stringify(res));
          if(res.status == 'Success' && res.user == 'resident')
          {
            modal.hide();
            var userlogin =  {
              userId   : res.user_id,
              orgId    : res.org_id,
              username : res.username,
              role     : res.user,
              mobile   : res.mobile
            }

            window.localStorage.setItem('current_user', JSON.stringify(userlogin));
            $scope.mob.pushPage('home.html',{ animation : 'fade' });
            setTimeout(function(){
              location.reload(true);
            },1000);
          }
          else if(res.status == 'Success' && res.user == 'child'){
            modal.hide();
            var childuserlogin =  {
              userId   : res.user_id,
              careId   : res.care_id,
              orgId    : res.org_id,
              username : res.username,
              role     : res.user,
              mobile   : res.mobile,
              resident_mobile : res.resident_mobile
            };

            window.localStorage.setItem('current_user', JSON.stringify(childuserlogin));
            $scope.care_name = res.username;

            $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
            setTimeout(function(){
              location.reload(true);
            },1000);
            
            // if(res.registration_status == 0)
            // {
            //   $scope.resident_mobile = res.resident_mobile;
            //   $scope.care_mobile = res.mobile;
            //   $scope.registration_status = res.registration_status;
            //   $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
            // }
            // else if(res.registration_status == 1)
            // {
            //   // $scope.care_subscription_check();
            //   $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade' });
            // }
            // else{
            //   // $scope.care_subscription_check();
            //   $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
            // }
          }
          else if(res.status == 'Success' && res.user == 'undefined') {
            modal.hide();
            $scope.usrerror = "Please select user role";
          }
          else if(res.status == 'Success' && res.user == 'child' && res.username == null) {
            modal.hide();
            $scope.mob.pushPage('careRegister.html',{ animation : 'fade' });
          }
          else {
            modal.hide();
            $scope.msgerror = res.message;
          }
        });
      }

    $scope.mydayactivity_detail = "";

    var currentuser = JSON.parse(localStorage.getItem("current_user"));
    // var resident_details = JSON.parse(localStorage.getItem("resident_details"));
    if(currentuser != '' || currentuser != null || currentuser != undefined)
    {
      //$scope.login();
     
      $scope.username = currentuser.username;
      $scope.userrole = currentuser.role;
      // $scope.resident_name=resident_details.resident_name;
      // $scope.resident_id=resident_details.resident_id;
      
      $scope.chkloginUser();      

     
      //$scope.mob.pushPage('home.html',{ animation : 'fade'});  
            

      $data.getAddays(currentuser).then(function(res){
        //console.log(res);
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth()+1; //January is 0!

          var yyyy = today.getFullYear();

          var today = yyyy+'-'+mm+'-'+dd;


          var newdate = new Date(res.app_install);
          newdate.setDate(newdate.getDate() + parseInt(res.ad_days));

          //var in_a_week = new Date().setDate(newdate.getDate()+7);
          
          var dd = newdate.getDate();
          var mm = newdate.getMonth() + 1;
          var y  = newdate.getFullYear();

          var ADdate = y + '-' + mm + '-' + dd;

          //console.log(ADdate);
          //console.log(today);


          if(today >= ADdate) {
            // admob.createBannerView();
          }

      });            
    }

    var current = $scope.mob.getCurrentPage();

    $scope.goBack = function(){
       if(current.page != 'home.html'){
         $scope.mob.popPage(current.page);
       }
       else if(current.page == 'dosomething.html' || current.page == 'eatsomething.html' || current.page == 'myday.html')
       {
          $scope.goHome();
       }
    }
    $scope.goBackCare=function()
    {
      $scope.mob.pushPage('Care_belongs.html',{ animation : 'fade'});
    }
    
    $scope.goHome = function() {
      // console.log("currentuser :"+currentuser.role);
      if(currentuser.role == 'resident')
      {
        $scope.mob.pushPage('home.html',{ animation : 'fade'});
      }
      else if(currentuser.role == 'child')
      {
        $scope.mob.pushPage('schedule.html',{ animation : 'fade'}); 
      }
    }


    $scope.goSchedule = function() {
      $scope.mob.pushPage('schedule.html',{ animation : 'fade'}); 
    }

    $scope.goCreditPay = function() {
      // console.log("Authorize Page clicked !");
      $scope.mob.pushPage('creditPage.html',{ animation : 'fade'}); 
    }
     
    $scope.backKeyDown = function(){
      var current = $scope.mob.getCurrentPage();
      if(current.page == 'home.html')
      {
          navigator.app.exitApp();
          //ons.notification.confirm("Are you sure you want to exit ?", onConfirm, "Confirmation", "Yes,No");
      }
    }

    $scope.gettime = function(time) {
      // console.log(time);
      // var d = new Date(time);
        var elem = time.split(':');
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

    // console.log($scope.appdata.getevents);

    $scope.showEvents = function() {
      newmodal.show(500);
      var event_arr = JSON.parse(localStorage.getItem("events"));
      // console.log("Events Array :"+JSON.stringify(event_arr));
      if( event_arr == null || event_arr.status == "Error")
      {
        $scope.showEventsRefresh();
      }
      else
      {
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        // console.log("currentuser :"+JSON.stringify(currentuser));
        $scope.appdata.events = event_arr;
        $scope.org_id  = currentuser.orgId;
        $scope.user_id = currentuser.userId;
        $scope.ekeys = Object.keys($scope.appdata.events);
        $scope.appdata.getevents = $scope.appdata.events[0];
        
        var eventid = $scope.appdata.events[0];

        if($scope.appdata.getevents.status == 'Error')
        {
          setTimeout(function(){
            $scope.$apply(function (){
              $scope.appdata.ekeys = 0;
            });
          });
        }
        else
        {   
          setTimeout(function(){
            $scope.$apply(function(){
              $scope.appdata.ekeys = Object.keys($scope.appdata.getevents);
            });
          });
        }
      }

      /** For Third Party API **/
      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      var currentuser_mobile = currentuser.mobile;
      $data.listEventbyApi(currentuser_mobile).then(function(res) {
        setTimeout('newmodal.hide()', 3000);
        
        if(res.status == 'Error' || res.text == 'No Event exist')
        {
          setTimeout(function(){
            $scope.$apply(function (){
              $scope.appdata.ekeys_api = 0;
            });
          });
        }
        else
        {   
          $scope.appdata.events_api = res;
          $scope.appdata.getevents_api = $scope.appdata.events_api[0];

          setTimeout(function(){
            $scope.$apply(function(){
              $scope.appdata.ekeys_api = Object.keys($scope.appdata.getevents_api);
            });
          });
        }
        $scope.opentab(0);
      });
      $scope.appdata.selected = 1;
    }

    $scope.showEventsRefresh = function(){
      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      // console.log("currentuser showEventsRefresh :"+JSON.stringify(currentuser));
      newmodal.show(); 
      $data.listEvents(currentuser).then(function(res){
          newmodal.hide(); 
          // console.log("Response :"+JSON.stringify(res));
          $scope.appdata.events = res;
          window.localStorage.setItem('events', JSON.stringify($scope.appdata.events));
          $scope.org_id  = currentuser.orgId;
          $scope.user_id = currentuser.userId;
          $scope.ekeys = Object.keys($scope.appdata.events);
          $scope.appdata.getevents = $scope.appdata.events[0];
          
          var eventid = $scope.appdata.events[0];

          if($scope.appdata.getevents.status == 'Error')
          {
            setTimeout(function(){
              $scope.$apply(function (){
                $scope.appdata.ekeys = 0;
              });
            });
          }
          else
          {   
            setTimeout(function(){
              $scope.$apply(function(){
                $scope.appdata.ekeys = Object.keys($scope.appdata.getevents);
              });
            });
          }
      });

      /** For Third Party API **/
      var currentuser_mobile = currentuser.mobile;
      $data.listEventbyApi(currentuser_mobile).then(function(res) {
        setTimeout('newmodal.hide()', 3000);
        
        if(res.status == 'Error' || res.text == 'No Event exist')
        {
          setTimeout(function(){
            $scope.$apply(function (){
              $scope.appdata.ekeys_api = 0;
            });
          });
        }
        else
        {   
          $scope.appdata.events_api = res;
          $scope.appdata.getevents_api = $scope.appdata.events_api[0];
          // console.log("Events APIs :"+JSON.stringify($scope.appdata.getevents_api));
          setTimeout(function(){
            $scope.$apply(function(){
              $scope.appdata.ekeys_api = Object.keys($scope.appdata.getevents_api);
            });
          });
        }
        $scope.opentab(0);
      });
      $scope.appdata.selected = 1;
    }

    $scope.showMeals = function($index) {
      newmodal.show();
      setTimeout(function(){newmodal.hide();},1000);

      var meals_arr = JSON.parse(localStorage.getItem("meals"));
      if( meals_arr == null)
      {
        $scope.showMealsRefresh();
      }
      else
      {
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        $scope.appdata.meals    = meals_arr;
        $scope.org_id           = currentuser.orgId;
        $scope.user_id          = currentuser.userId;
        $scope.appdata.getmeals = $scope.appdata.meals[0];

        if($scope.appdata.getmeals.status == 'Error')
        {
          $scope.appdata.mkeys = 0;
        }
        else
        {
          $scope.appdata.mkeys = Object.keys($scope.appdata.getmeals);
        }
        $scope.opentab(1);

        $scope.appdata.selected = 2; 
      }
    };

    $scope.showMealsRefresh = function() {
      newmodal.show();
      $data.listMeal(currentuser).then(function(res) {
        newmodal.hide();
        $scope.appdata.meals    = res;
        window.localStorage.setItem('meals', JSON.stringify($scope.appdata.meals));
        $scope.org_id           = currentuser.orgId;
        $scope.user_id          = currentuser.userId;
        $scope.appdata.getmeals = $scope.appdata.meals[0];

        if($scope.appdata.getmeals.status == 'Error')
        {
          $scope.appdata.mkeys = 0;
        }
        else
        {
          $scope.appdata.mkeys = Object.keys($scope.appdata.getmeals);
        }
        $scope.opentab(1);
      });
      $scope.appdata.selected = 2; 
    };

    $scope.add_family = function(scope) {
      newmodal.show();
      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      var residentId=currentuser.userId;
      var form_data = {
        resident_id : residentId
      };

      $.ajax({
        type: 'POST',
        data: form_data,
        url: "http://www.yourday.io/index.php/api?func=resident_addcare_limit&sec_token=YHDgjy9Q7yuDFgTE",
        success: function(response){
          newmodal.hide();
          // console.log("Care Lists :"+JSON.stringify(response.care_list));
          $scope.care_exist = response.noc;
          $scope.care_list = response.care_list;
          $scope.care_add = 2;
          $scope.mob.pushPage('add_family.html',{ animation : 'fade'});  
        },
        error: function(error){
          newmodal.hide();
          var err = "Error :"+JSON.stringify(error);
          ons.notification.alert({
            message: err
          });
          $scope.mob.pushPage('add_family.html',{ animation : 'fade'}); 
        }
      }); 
    }
    


    $scope.showMydays = function(index) {
      newmodal.show();
      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      // console.log("currentuser showMydays :"+JSON.stringify(currentuser));
      $data.new_listUserdays(currentuser).then(function(res) {
        newmodal.hide();
        // console.log("Response new_listUserdays :"+JSON.stringify(res));
        if(res[0].status == 'Error')
        {
          $scope.myday_msg = 'No Data Available';
          setTimeout(function(){
            $scope.$apply(function () {
              $scope.appdata.mydayekeys = 0;
            });
          },1000);
        }
        else
        {
          $scope.appdata.userevents = res[0].events;
          $scope.appdata.usermeals = res[0].meals;

          if($scope.appdata.userevents[0].status == 'Error')
          {
            $scope.appdata.userekeys = 0;
          }
          else
          {
            $scope.appdata.userevents.forEach(function(data) {
              $scope.appdata.usereventlist = data;
              $scope.appdata.userekeys = Object.keys($scope.appdata.usereventlist);
            });
          }
          
          if($scope.appdata.usermeals[0].status == 'Error')
          {
            $scope.appdata.usermkeys = 0;
          }
          else
          {
            $scope.appdata.usermeals.forEach(function(data) {
              $scope.appdata.usermeallist = data;
              $scope.appdata.usermkeys = Object.keys($scope.appdata.usermeallist);
            });
          }
        }
          $scope.org_id   = currentuser.orgId;
          $scope.user_id  = currentuser.userId;
          $scope.opentab(2);
          $scope.mob.pushPage('myday.html',{ animation : 'fade' });
      });
      $scope.appdata.selected = 3;
    }

    $scope.showMydaysChild = function(index) {
      newmodal.show();

        $data.listUserdays(currentuser).then(function(res) {
          newmodal.hide();

          if(res[0].status == 'Error'){
              $scope.myday_msg = 'No Data Available';
              setTimeout(function(){
                $scope.$apply(function () {
                  $scope.appdata.mydayekeys = 0;
                });
              },1000);
          }

          else{
              $scope.appdata.userevents = res[0].events;
              $scope.appdata.usermeals = res[0].meals;

              // console.log($scope.userevents[0].status);

              // console.log($scope.usermeals);

              if($scope.appdata.userevents[0].status == 'Error')
              {
                $scope.appdata.userekeys = 0;
              }
              else
              {
                $scope.appdata.userevents.forEach(function(data) {
                  $scope.appdata.usereventlist = data;
                  $scope.appdata.userekeys = Object.keys($scope.appdata.usereventlist);
                });
              }

              if($scope.appdata.usermeals[0].status == 'Error')
              {
                  $scope.appdata.usermkeys = 0;
              }
              else
              {
                  $scope.appdata.usermeals.forEach(function(data) {
                      $scope.appdata.usermeallist = data;
                      $scope.appdata.usermkeys = Object.keys($scope.appdata.usermeallist);
                  });
              }

          }

          $scope.org_id   = currentuser.orgId;
          $scope.user_id  = currentuser.userId;
          // $scope.opentab(2);
          $scope.mob.pushPage('myday.html',{ animation : 'fade' });
        });
        $scope.appdata.selected = 3;
    }

      $scope.event_detail = function(event,date) {
        newmodal.show();
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var eventid = event.id;
        var plan_event_id = event.event_id;
        
        $data.singleEvent(event).then(function(res){
          newmodal.hide();
          $scope.org_id   = currentuser.orgId;
          $scope.user_id  = currentuser.userId;
          $scope.eventdetail = res[0];
          $scope.curdate  = date;
          $scope.mob.pushPage('eventdetail.html',{ animation : 'slide' });
        });

        if(event.thirdparty_access == 1)
        {
          $data.selectedEventdates_thirdParty(eventid).then(function(res){
            $scope.event_status = res[0].status;
            $scope.join_status = false;
            
            var status = $scope.event_status;
            if(status == 1)
            {
              $scope.join_status = true;
            }
            else{
              $scope.join_status = false;
            }
          });
        }
        else{
          $data.selectedEventdates(eventid,date).then(function(res){
            $scope.event_status = res[0].event_status;
            $scope.join_status = false;
            
            var status = $scope.event_status;
            if(status == 1)
            {
              $scope.join_status = true;
            }
            else{
              $scope.join_status = false;
            }
          });
        }
        $data.checkEvent(eventid).then(function(res) {
          $scope.chk_eventusers = false;
            if(res[0].attendie_status == 'false' && $scope.join_status == 'false') {  
              $scope.chk_eventusers = true;
              ons.notification.alert({
                message: 'The attendies limit has exceeded . You are not allowed to join !',
                title: 'Alert',
                buttonLabel: 'OK',
                animation: 'default'
              });
            }
            else {
              $scope.chk_eventusers = false;
              $scope.message = res[0].message;
            }
        });
    };

      $scope.meal_detail = function(meal,mealday) { 
        var mealid = meal.id;

        $scope.selectedday = mealday;

        $scope.daysarr  = [ 'today','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday'];

        var dayvalue = $scope.daysarr.indexOf($scope.selectedday);
        
           //console.log(mealday);
            $data.singleMeal(meal).then(function(res){
              // $scope.org_id  = userData.org_id;
              // $scope.user_id = userData.user_id;
              $scope.mealdetail = res[0];
              $scope.mealday = mealday;
              //alert(JSON.stringify($scope.mealdetail));
              $scope.mob.pushPage('mealdetail.html',{ animation : 'slide' });
               
          });

          $data.selectedMealdates(mealid,dayvalue).then(function(res){
              // console.log("Meal ID :"+mealid+" && Dayvalue :"+dayvalue);
              // console.log("Response :"+JSON.stringify(res));
              $scope.meal_status = res[0].meal_status;
              $scope.mealjoin_status = false;
              
              var status = $scope.meal_status;
              // console.log(status);
              if(status == 1)
              {
                $scope.mealjoin_status = true;
              }
              else {
                $scope.mealjoin_status = false;
              }
          }); 
      }

      $scope.joined_eventUser = function(detail,eventdate){
        // console.log(joinuser);
        var joinuser = {
             id : detail.id,
             singledate: eventdate
        }
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

      $scope.join_eventdate = function(details,dateinfo) {

        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var eventid = details.id;

        if( details.thirdparty_access == 1)
        {
          $data.addEvent_thirdParty(eventid).then(function(res) {
            $scope.join_status_thirdParty = false;
            if(res.status == 'success') {
              $scope.message = "You have been successfully joined this event. We Will see you there!";
              $scope.join_status_thirdParty = true;
            }
            else {
              $scope.message = res.text;
              $scope.join_status_thirdParty = false;
            }
          });
          setTimeout(function(){
            $scope.mob.pushPage('home.html',{ animation : 'fade'});
          },500);  
        }
        
        else
        {
          $scope.mob.pushPage('recurringevent.html',{ animation : 'slide' });
          
          $data.listEventDates(eventid,dateinfo).then(function(res){
            $scope.listeventdays = JSON.parse(JSON.stringify(res));
            $scope.eventid       = eventid;
            $scope.pusharray     = [];

            $scope.daysarr  = [ 'Just Today','Every Sunday', 'Every Monday', 'Every Tuesday', 'Every Wednesday', 'Every Thursday','Every Friday', 'Every Saturday'];
             
            angular.forEach($scope.listeventdays,function(val,key) {
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
              
              $data.addEvent(addevent).then(function(res) {
                if(res[0].status == 'Success') {
                  $scope.message = "You have been successfully joined this event. We Will see you there!";
                }
                else {
                  $scope.message = res[0].message;
                }
              });
              setTimeout(function(){
                $scope.showEventsRefresh();
              },500);
            }

            $data.selectedEventdates(eventid,dateinfo).then(function(res){
              $scope.eventsdate = res[0];
              angular.forEach($scope.eventsdate,function(useroption) {
                $scope.selectedoptions = useroption;
                $scope.selectevents    = $scope.selectedoptions;
              });
              var idx = $scope.selectevents.indexOf($scope.selectedoptions);
            });  
          });    
        }     
      }


      $scope.delete_eventdate = function(event,singledate) {
        var delevent = {
          event_id   : event.id,
          singledate : singledate
        }
        var event_id = event.id ;
        
        if( event.thirdparty_access == 1)
        {
          $data.deleteEvent_thirdParty(event_id).then(function(res) {
            if(res.status == 'success') {
              $scope.join_status = true;
              $scope.message = "You have successfully deleted this event. Thank You !";
              $scope.mob.pushPage('home.html',{ animation : 'fade'});
            }
            else {
              $scope.message = res.text;
            }
          });
        }
        else
        {
          $data.deleteEvent(delevent).then(function(res) {
            if(res[0].status == 'Success') {
              $scope.join_status = true;
              $scope.message = "You have successfully deleted this event. Thank You !";
              setTimeout(function(){
                $scope.showEventsRefresh();
              },500);
            }
            else {
              $scope.message = res[0].message;
            }
          });
        } 
      }
      
       $scope.join_meal = function(joinmeal){
        $data.joinMeal(joinmeal).then(function(res) {
          $scope.joinmeals = res;
          // $scope.org_id  = userData.org_id;
          // $scope.user_id = userData.user_id;
          if(res[0].status == 'Success') {
             $scope.message = "You have been successfully joined this meal event. We Will see you there !";
          }
          else {
             $scope.message = res[0].message;
          }
          // $scope.mob.pushPage('joined.html',{ animation : 'slide' });
        });
      }

      $scope.join_mealdate = function(mealid,mealcurrentday) {
        // console.log("Meal ID : "+mealid+" && Meal Current Day :"+mealcurrentday);
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        $scope.mob.pushPage('recurringmeal.html',{ animation : 'slide' });
        $data.listMealdates(mealid).then(function(res) {
          // console.log("List Meals Response :"+JSON.stringify(res));
          $scope.mealtime = res;
          
          $scope.selectedday = mealcurrentday;

          $scope.daysarr  = [ 'today','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday'];

          var dayvalue = $scope.daysarr.indexOf($scope.selectedday);
          
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

              // console.log(week_day);
              // console.log(currentday);

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
                // console.log(getdates);

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

              setTimeout(function(){
                $scope.showMealsRefresh();
              },500);
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
        $scope.delete_mealdate = function(meal,mealcurrentday) {

          $scope.selectedday = mealcurrentday;

          $scope.daysarr  = [ 'today','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday'];

          var dayvalue = $scope.daysarr.indexOf($scope.selectedday);
              
          var delevent = {
              meal_id  : meal.id,
              mealtime : meal.startime,
              useroption : dayvalue
          }
          
          $data.deleteMeal(delevent).then(function(res) {
            // console.log("Test Response :"+JSON.stringify(res[0]));
            if(res[0].status == 'Success') {
              $scope.mealjoin_status = true;
              $scope.message = "You have successfully deleted this event. Thank You !";
              setTimeout(function(){
                $scope.showMealsRefresh();
              },500);
            }
            else {
              $scope.message = res[0].message;
            }
          });
        }
    });
  });
 
  module.controller('loginController', function($scope,$data) {
    $('.navbar-fixed-bottom').hide();
  });

  module.controller('mloginController', function($scope,$data) {
    $('.navbar-fixed-bottom').hide(); 
  });

  module.controller('MobileController', function($scope,$data) {
    $('.navbar-fixed-bottom').hide();

    var current = $scope.mob.getCurrentPage();

   $scope.goCreditPay = function() {
      // console.log("Authorize Page clicked !");
      $scope.mob.pushPage('creditPage.html',{ animation : 'fade'}); 
    }

  });

  module.controller('DoSomethingController', function($scope, $data){
    $('.navbar-fixed-bottom').show();
    var parentevents = $scope.$parent.eventlist;
    $scope.allevents = parentevents;
    var currentuser = JSON.parse(localStorage.getItem("current_user"));
    
    $data.listUserdays(currentuser).then(function(res){
      $scope.appdata.userevents = res[0].events;
      $scope.allmyevents = [];
      var object = {};

      angular.forEach($scope.appdata.userevents,function(allmyeventdays){
        angular.forEach(allmyeventdays,function(allmylist){
          $scope.mydaylist = allmylist;
          angular.forEach(allmylist,function(mylist){
            $scope.allmyevents.push(mylist.name+"-"+mylist.range_date+"-"+mylist.status);
          });
        });
      });
    });  
  });

  module.controller('ScheduleCalendarController', function($scope, $data) {
    $scope.appdata = {};
    $scope.appdata.selected = 0;
    $scope.appdata.getevents = {};
    $scope.appdata.events = {};
    $scope.appdata.ekeys = 0;
    $scope.appdata.meals = {};
    $scope.appdata.getmeals = {};
    $scope.appdata.mkeys = 0;
    $scope.appdata.userevents = {};
    $scope.appdata.usermeals  = {};
    $scope.appdata.userekeys  = 0;
    $scope.appdata.usereventlist = {};
    $scope.appdata.usermkeys = 0;
    $scope.appdata.usermeallist = {};
    var show_userevent = false;

    newmodal.show();
    
    var currentuser = JSON.parse(localStorage.getItem("current_user"));
    if(currentuser != null)
    {
      // console.log("Current User under ScheduleCalendarController :"+JSON.stringify(currentuser));
      $data.listEvents(currentuser).then(function(res) {
        newmodal.hide();
        $scope.appdata.events = res;
        $scope.org_id  = currentuser.orgId;
        $scope.user_id = currentuser.userId;
        $scope.appdata.getevents = $scope.appdata.events[0];

        // console.log("Response after Get :"+JSON.stringify($scope.appdata.getevents));

        var eventid = $scope.appdata.events[0];

        if($scope.appdata.getevents.status == 'Error')
        {
          setTimeout(function(){
            $scope.$apply(function (){
              $scope.appdata.ekeys = 0;
            });
          });
        }
        else
        {   
          setTimeout(function(){
            $scope.$apply(function(){
              $scope.appdata.ekeys = Object.keys($scope.appdata.getevents);
            });
          });
        }
      });
    }
    else
    {
      var siteCode = localStorage.getItem("site_code");
      $data.listEventbysite_code(siteCode).then(function(res){
        newmodal.hide();
        if( res.status == "Error")
        {
          ons.notification.alert({
            message: 'Please Enter a Valid Site Code !',
            title: 'Site Code Verify',
            buttonLabel: 'OK',
            animation: 'default'
          });
          $scope.mob.pushPage('calendar.html',{ animation : 'fade'});
        }
        else
        {
          $scope.appdata.events = res;
          $scope.appdata.getevents = $scope.appdata.events[0];

          var eventid = $scope.appdata.events[0];

          if($scope.appdata.getevents.status == 'Error')
          {
            setTimeout(function(){
              $scope.$apply(function (){
                $scope.appdata.ekeys = 0;
              });
            });
          }
          else
          {   
            setTimeout(function(){
              $scope.$apply(function(){
                $scope.appdata.ekeys = Object.keys($scope.appdata.getevents);
              });
            });
          }
        }
      });
    } 

    $scope.gettime = function(time) {
      // console.log(time);
      // var d = new Date(time);
      var elem = time.split(':');
      // var stSplit = elem[1].split(":");
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
    }

    $scope.goHome = function() {
      $scope.mob.pushPage('schedule.html',{ animation : 'fade'}); 
    }

    $scope.goCreditPay = function() {
      // console.log("Authorize Page clicked !");
      $scope.mob.pushPage('creditPage.html',{ animation : 'fade'}); 
    }

    $scope.goCreditPay_after = function() {
      $scope.mob.pushPage('careRegister.html',{ animation : 'fade'}); 
    }
    
  });
  
  module.controller('EatSomethingController', function($scope, $data) {
    $('.navbar-fixed-bottom').show();
    var parentmeals = $scope.$parent.meals;
    $scope.allmeal  = parentmeals;
    var selectedday = '';

    var currentuser = JSON.parse(localStorage.getItem("current_user"));
       
    $data.listUserdays(currentuser).then(function(res){
      // console.log("REsponse :"+JSON.stringify(res));
      $scope.appdata.usermeals = res[0].meals;
      $scope.allmymeals = [];

      angular.forEach($scope.appdata.usermeals,function(allmymealdays) {
        angular.forEach(allmymealdays,function(allmylist) {
          $scope.mydaylist = allmylist[0];

          var selectedday = $scope.mydaylist.week_day;
          $scope.daysarr  = ['today', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

          angular.forEach(allmylist,function(mylist){
            $scope.allmymeals.push(mylist.name+"-"+$scope.daysarr[selectedday]);
          });
          // console.log($scope.allmymeals);
        });
      });
    });
  });

  module.controller('MydayController', function($scope, $data){
    $('.navbar-fixed-bottom').show();
    $scope.myeventdays    = $scope.$parent.appdata.userevents;

    if($scope.myeventdays != undefined){
      $scope.allmyeventdays = $scope.myeventdays[0];
    }

    $scope.mymealdays    = $scope.$parent.appdata.usermeals;

    if($scope.mymealdays != undefined){
      $scope.allmymealdays = $scope.mymealdays[0];
    }

    $scope.isloaded = false;

    $('.events-list-view').show();
    $('.calender-list-view').hide();
    $('.calview').show();
    $('.listview').hide(); 
      
      var events = [];
      var today = new Date();

  });
  

  module.controller('MydayChildController', function($scope, $data){
    $scope.appdata = {};
    $scope.appdata.selected = 0;
    $scope.appdata.getevents = {};
    $scope.appdata.events = {};
    $scope.appdata.ekeys = 0;
    $scope.appdata.meals = {};
    $scope.appdata.getmeals = {};
    $scope.appdata.mkeys = 0;
    $scope.appdata.userevents = {};
    $scope.appdata.usermeals  = {};
    $scope.appdata.userekeys  = 0;
    $scope.appdata.usereventlist = {};
    $scope.appdata.usermkeys = 0;
    $scope.appdata.usermeallist = {};
    var show_userevent = false;

    var currentuser = JSON.parse(localStorage.getItem("current_user"));

    if( currentuser != null)
    {
      // $scope.childdata = function()
      // {
        newmodal.show();
        $('.navbar-fixed-bottom').hide();

        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        // console.log("Current User :"+JSON.stringify(currentuser));

        $data.new_listUserdays(currentuser).then(function(res){
          newmodal.hide();
          if(res[0].status == 'Error'){
            $scope.myday_msg = 'No Data Available';
            setTimeout(function(){
              $scope.$apply(function(){
                $scope.appdata.mydayekeys = 0;
              });
            },1000);
          }
          else
          {
            $scope.appdata.userevents = res[0].events;
            $scope.appdata.usermeals  = res[0].meals;

            $scope.myeventdays    = $scope.appdata.userevents;
            
            if($scope.appdata.userevents[0].status == 'Error')
            {
              $scope.appdata.userekeys = 0;
            }
            else
            {
              $scope.appdata.userevents.forEach(function(data) {
                $scope.appdata.usereventlist = data;
                $scope.appdata.userekeys = Object.keys($scope.appdata.usereventlist);
              });
            }

            if($scope.appdata.usermeals[0].status == 'Error')
            {
              $scope.appdata.usermkeys = 0;
            }
            else
            {
              $scope.appdata.usermeals.forEach(function(data) {
                $scope.appdata.usermeallist = data;
                $scope.appdata.usermkeys = Object.keys($scope.appdata.usermeallist);
              });
            }
          }
          $scope.org_id   = currentuser.orgId;
          $scope.user_id  = currentuser.userId;
        });

        if($scope.myeventdays != undefined){
          $scope.allmyeventdays = $scope.myeventdays[0];
        }
                
        if($scope.mymealdays != undefined){
          $scope.allmymealdays = $scope.mymealdays[0];
        }
      // }
    }
    else{
      newmodal.hide();
      ons.notification.alert({
        message: 'Subscription plan are not implemented yet !',
        title: 'Subscribe',
        buttonLabel: 'OK',
        animation: 'default'
      });
      $scope.mob.pushPage('schedule.html',{ animation : 'fade'});
    }      
    
    // $scope.childdata();

    $scope.getday = function(day){
      $scope.currentday = day ;
      $scope.daysarr  = [ 'today','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday', 'Saturday'];
      return $scope.daysarr[day];
    }

    $scope.gettime = function(time) {
        var elem = time.split(':');
        var stHour = elem[0];
        var stMin = elem[1];
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
    }

  });

  module.controller('EventController', function($scope, $data) {
    $('.navbar-fixed-bottom').show();
    var detailinfo = $scope.$parent.eventdetail;
    var dateinfo = $scope.$parent.curdate;
    $scope.singledate = dateinfo;
    $scope.details = detailinfo;
    $scope.eventtitle = detailinfo.event_name;
    $scope.eventid = detailinfo.id;
  });

  module.controller('MealController', function($scope, $data) {
    $('.navbar-fixed-bottom').show();
    var mealinfo = $scope.$parent.mealdetail;
    $scope.meal_detail = mealinfo;
    $scope.mealtitle = mealinfo.meal_type;
    $scope.mealcurrentday = $scope.$parent.mealday;
  });

  module.controller('JoinEventUsersController',function($scope,$data){
    $('.navbar-fixed-bottom').show();
      var joined_userinfo = $scope.$parent.joinuserdetails;
      $scope.joinedusers  = joined_userinfo;

      var detailinfo     = $scope.$parent.eventdetail;
      var dateinfo       = $scope.$parent.curdate;
      $scope.singledate  = dateinfo;
      $scope.details     = detailinfo;
      $scope.eventtitle  = detailinfo.event_name;
      $scope.eventid     = detailinfo.id;
  });

  module.controller('JoinMealUsersController',function($scope,$data){

    $('.navbar-fixed-bottom').show();
      var joined_mealuserinfo   = $scope.$parent.joinmealusers;
      $scope.joined_mealusers   = joined_mealuserinfo;

      var mealinfo       = $scope.$parent.mealdetail;
      $scope.meal_detail = mealinfo;
      $scope.mealtitle   = mealinfo.meal_type;
      $scope.mealcurrentday = $scope.$parent.mealday;
    
  });

  module.controller('recurringController',function($scope,$data) {
    $('.navbar-fixed-bottom').show();

    var detailinfo     = $scope.$parent.eventdetail;
    $scope.details     = detailinfo;
  });

  module.controller('recurringmealController',function($scope,$data) {

    $('.navbar-fixed-bottom').show();

    var mealinfo       = $scope.$parent.mealdetail;
    $scope.meal_detail = mealinfo;
  });
  

  module.controller('JoinedController',function($scope,$data){
    $scope.item = $data.selectedItem;
  });

  module.controller('AddFamilyController', ['$scope', function($scope){
    $scope.remind_resident = function(){
      newmodal.show();
      $scope.mobile_array = [];
      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      var resident_iD = currentuser.userId;
      // console.log("residentId:"+resident_iD);
      var   phoneno=angular.element(document.getElementById("phonenum1"));
      $scope.textbox1 = phoneno.val();
      var phonenum1=$scope.textbox1;

      var phoneno=angular.element(document.getElementById("phonenum2"));
      $scope.textbox2 = phoneno.val();
      var phonenum2=$scope.textbox2;

       var phoneno=angular.element(document.getElementById("phonenum3"));
      $scope.textbox3 = phoneno.val();
      var phonenum3=$scope.textbox3;

      var phoneno=angular.element(document.getElementById("phonenum4"));
      $scope.textbox4 = phoneno.val();
      var phonenum4=$scope.textbox4;
      var regExp={0:'(',3:')-',6:' - '};
  
      // console.log("numbers"+phonenum1,phonenum2,phonenum3,phonenum4);
          
      if($scope.care_exist == 0)
      {
        if( phonenum1!= '' && phonenum2 == '' && phonenum3 == '' && phonenum4 == '')
          {
            if(phonenum1.match(regExp))
            {
                var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                $scope.mobile_array.push(phonenumber1);  
            }
            else
            {
                $scope.mobile_array.push(phonenum1);
            }
           
          }
          else if(phonenum1 != '' && phonenum2 != '' &&phonenum3 == '' && phonenum4 == '')
          {
            if(phonenum1.match(regExp) )
            {
              if(phonenum2.match(regExp))
              {
                var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                var phonenumber2 = phonenum2.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                $scope.mobile_array.push(phonenumber1,phonenumber2);  
              }
            }
            else
             {
               $scope.mobile_array.push(phonenum1,phonenum2);  
             }
          }
          else if(phonenum1 != '' && phonenum2 != '' && phonenum3 != '' && phonenum4 == '')
          {
            if(phonenum1.match(regExp))
            {
              if(phonenum2.match(regExp))
              {
                if(phonenum3.match(regExp))
                {
                  var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  var phonenumber2 = phonenum2.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  var phonenumber3 = phonenum3.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  $scope.mobile_array.push(phonenumber1,phonenumber2,phonenumber3);  
                }
              }
            }
            else
            {
              $scope.mobile_array.push(phonenum1,phonenum2,phonenum3);  
            } 
        }

      else if(phonenum1 != '' && phonenum2 != '' && phonenum3 != '' && phonenum4 != '' )
        {
          if(phonenum1.match(regExp))
            {
              if(phonenum2.match(regExp) )
              {
                if(phonenum3.match(regExp))
                {
                  if(phonenum4.match(regExp))
                  {
                    var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                    var phonenumber2 = phonenum2.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                    var phonenumber3 = phonenum3.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                    var phonenumber4 = phonenum4.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                    $scope.mobile_array.push(phonenumber1,phonenumber2,phonenumber3,phonenumber4);  
                  }
                }
              }
            }
            else
            {
            $scope.mobile_array.push(phonenum1,phonenum2,phonenum3,phonenum4);
            }
        }
      }
      else if($scope.care_exist>0 && $scope.care_exist==1)
      { 
        if( phonenum1 != '' && phonenum2 == '' && phonenum3 == '')
          {
            if(phonenum1.match(regExp))
              {
                var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                $scope.mobile_array.push(phonenumber1);  
              }
            else
              {
                $scope.mobile_array.push(phonenum1);  
              }
          }
          else if(phonenum1 != '' && phonenum2 != '' && phonenum3 == '')
          {
            if(phonenum1.match(regExp) )
            {
              if(phonenum2.match(regExp) )
              {
                var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                var phonenumber2 = phonenum2.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  $scope.mobile_array.push(phonenumber1,phonenumber2);  
              }
            }
            else
            {
              $scope.mobile_array.push(phonenum1,phonenum2);  
            }
          }
          else if(phonenum1 != '' && phonenum2 != '' && phonenum3 != '')
          {
            if(phonenum1.match(regExp))
            {
              if(phonenum2.match(regExp))
              {
                if(phonenum3.match(regExp))
                {
                  var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  var phonenumber2 = phonenum2.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  var phonenumber3 = phonenum3.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  $scope.mobile_array.push(phonenumber1,phonenumber2,phonenumber3);  
                }
              }
            }
            else
            {
              $scope.mobile_array.push(phonenum1,phonenum2,phonenum3);  
            }
          }
          
      }
      else if($scope.care_exist>0 && $scope.care_exist==2)
      {
       if( phonenum1 != '' && phonenum2 == '')
        {
            if(phonenum1.match(regExp))
            {
              var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
              $scope.mobile_array.push(phonenumber1); 
            }
            else
            {
                 $scope.mobile_array.push(phonenum1); 
            }
        }
        else if(phonenum1 != '' && phonenum2 != '')
        {
            if(phonenum1.match(regExp))
            {
              if(phonenum2.match(regExp))
              {
                  var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  var phonenumber2 = phonenum2.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
                  $scope.mobile_array.push(phonenumber1,phonenumber2);
              }
            }
        else
          {
             $scope.mobile_array.push(phonenum1,phonenum2); 
          }
        }
     
      }
      else if($scope.care_exist==3)
      { 
         if(phonenum1.match(regExp))
         {
            var phonenumber1 = phonenum1.replace("(", "").replace(")", "").replace("-", "").replace(" ", "").replace("-", "").replace(" ", "");
            $scope.mobile_array.push(phonenumber1); 
          }
          else
          {
            $scope.mobile_array.push(phonenum1); 
          }
      }

      var mobile_array = $scope.mobile_array;

      var form_data={
        resident_id: resident_iD,
        mobile : mobile_array
      };

      // console.log("Form Data :"+JSON.stringify(form_data));
      
      $.ajax({
        type: 'GET',
        data: form_data,
        url: "http://www.yourday.io/index.php/api?func=check_andsend_linkcare&sec_token=YHDgjy9Q7yuDFgTE",
        success: function(response){
          newmodal.hide();
          // console.log("Response check_andsend_linkcare :"+JSON.stringify(response));
          ons.notification.alert({
            message: response.message
          });
        },
        error: function(error){
          newmodal.hide();
          var err = "Error :"+JSON.stringify(error);
          // console.log(err);
          ons.notification.alert({
            message: err
          });
        }
      });
    };

    $scope.resendMessage = function(phonenumber){
      var number = phonenumber;
      var mobile_resend_array = [];
      mobile_resend_array.push(number);

      var currentuser = JSON.parse(localStorage.getItem("current_user"));
      var resident_iD = currentuser.userId;

      var form_data={
        resident_id: resident_iD,
        mobile : mobile_resend_array
      };

      // console.log("Form Data :"+JSON.stringify(form_data));
      
      newmodal.show();
      $.ajax({
        type: 'GET',
        data: form_data,
        url: "http://www.yourday.io/index.php/api?func=resend_linktocare&sec_token=YHDgjy9Q7yuDFgTE",
        success: function(response){
          newmodal.hide();
          // console.log("Response :"+JSON.stringify(response));
          ons.notification.alert({
            message: response.message
          });
        },
        error: function(error){
          newmodal.hide();
          var err = "Error :"+JSON.stringify(error);
          // console.log(err);
          ons.notification.alert({
            message: err
          });
        }
      });
    };
    
  }]);

  module.factory('$data',function($http){
      var data = {};
      var apiUrl = 'http://www.yourday.io/index.php/api';
      var thirdPartyUrl = 'http://www.yourday.io/index.php/Thirdparty';
      
      // var apiUrl = 'http://52.43.178.84/index.php/api';
      
      data.getsitecode_mob = function(mobilenum){
        var getUsers = $http.get(apiUrl +'?func=getsitecode_mob&sec_token=YHDgjy9Q7yuDFgTE&mobilenum='+mobilenum).then(function(response){
          return response.data;
        });
        return getUsers;
      }

      data.getUserInfo = function(user_uuid){
        var getUsers = $http.get(apiUrl +'?func=getAppUser&sec_token=YHDgjy9Q7yuDFgTE&uuid='+user_uuid).then(function(response){
          return response.data;
        });
        return getUsers;
      }
      
      data.getloginedUser = function(userId){
        var getUsers = $http.get(apiUrl +'?func=getloginedUser&sec_token=YHDgjy9Q7yuDFgTE&userid='+userId).then(function(response){
          return response.data;
        });
        return getUsers;
      }

      data.getAddays = function(currentuser){
         var getUsers = $http.get(apiUrl +'?func=getAddays&sec_token=YHDgjy9Q7yuDFgTE&user_id='+currentuser.userId+'&org_id='+currentuser.orgId).then(function(response){
          return response.data;
        });
        return getUsers;
      }

      data.getUserLogin = function(mobilenum , user){
        var getUsers = $http.get(apiUrl +'?func=userLogin&sec_token=YHDgjy9Q7yuDFgTE&user='+user+'&mobilenum='+mobilenum).then(function(response){
          return response.data;
        });
        return getUsers;
      }

      /** Custom 27-01-2017 **/
      data.getCustomUserLogin = function(uniqueid){
        var getUsers = $http.get(apiUrl +'?func=verify_user&sec_token=YHDgjy9Q7yuDFgTE&uuid='+uniqueid).then(function(response){
          return response.data;
        });
        return getUsers;
      }

      data.listEvents = function(currentuser){
        var events = $http.get(apiUrl +'?func=listEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+"&resident_id="+currentuser.userId).then(function(response){
          return response.data;
        });
        return events;
      }

      data.listEventbysite_code = function(site_code){
        var events = $http.get(apiUrl +'?func=list_event_bysitecode&sec_token=YHDgjy9Q7yuDFgTE&sitecode='+site_code).then(function(response){
          return response.data;
        });
        return events;
      }

      data.listEventbyApi = function(mobile){
        var events = $http.get(thirdPartyUrl+'/get_via_phonenumber?api_key=10cf93697d7155ac0d368bbafbc842a4&resident_phone='+mobile).then(function(response){
          return response.data; // 8767767777
        });
        return events;
      }

      data.listMeal = function(currentuser){
        var meals = $http.get(apiUrl +'?func=listMeal&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&resident_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return meals;
      }

      data.listUserdays = function(currentuser) {
        var myday = $http.get(apiUrl + '?func=listUserdays&sec_token=YHDgjy9Q7yuDFgTE&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return myday;
      }

      data.new_listUserdays = function(currentuser) {
        var myday = $http.get(apiUrl + '?func=new_listUserdays&sec_token=YHDgjy9Q7yuDFgTE&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return myday; 
      }

      data.listEventDates = function(singleevent,singledate){
        var myday = $http.get(apiUrl + '?func=listEventDates&sec_token=YHDgjy9Q7yuDFgTE&event_id='+singleevent+'&singledate='+singledate).then(function(response){
          return response.data;
        });
        return myday;
      }

      data.listMealdates = function(singlemeal) {
        var myday = $http.get(apiUrl + '?func=listMealDates&sec_token=YHDgjy9Q7yuDFgTE&plan_meal_id='+singlemeal).then(function(response){
          return response.data;
        });
        return myday;
      }

      data.addEvent = function(addevent) {
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var add_event = $http.get(apiUrl + '?func=addEventrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+addevent.useroption+'&id='+addevent.event_id+'&singledate='+addevent.singledate+'&user_id='+currentuser.userId+'&org_id='+currentuser.orgId).then(function(response) {
          return response.data;
        });
        return add_event;
      }

      data.addEvent_thirdParty = function(eventid) {
        var add_event = $http.get(thirdPartyUrl+"/add_resident_event?api_key=10cf93697d7155ac0d368bbafbc842a4&event_id="+eventid).then(function(response) {
          return response.data;
        });
        return add_event;
      }

      data.checkEvent = function(eventid) {
        var check_event = $http.get(apiUrl + '?func=checkEventrange&sec_token=YHDgjy9Q7yuDFgTE&plan_event_id='+eventid).then(function(response) {
          return response.data;
        });
        return check_event;
      }

      data.deleteEvent = function(delevent) {
        var currentuser = JSON.parse(localStorage.getItem("current_user")); 
        var delete_event = $http.get(apiUrl + '?func=deleteEventrange&sec_token=YHDgjy9Q7yuDFgTE&id='+delevent.event_id+'&singledate='+delevent.singledate+'&user_id='+currentuser.userId+'&org_id='+currentuser.orgId).then(function(response) {
          return response.data;
        });
        return delete_event;
      }

      data.deleteEvent_thirdParty = function(eventid) {
        var delete_event = $http.get(thirdPartyUrl+"/delete_resident_event?api_key=10cf93697d7155ac0d368bbafbc842a4&event_id="+eventid).then(function(response) {
          return response.data;
        });
        return delete_event;
      }

      data.addMeal = function(addmeal) {
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var add_meal = $http.get(apiUrl + '?func=addMealrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+addmeal.useroption+'&meal_time='+addmeal.mealtime+'&id='+addmeal.meal_id+'&meal_date='+addmeal.mealdate+'&user_id='+currentuser.userId+'&org_id='+currentuser.orgId).then(function(response){
          return response.data;
        });
        return add_meal;

      }

      data.deleteMeal = function(delmeal) {
        var currentuser = JSON.parse(localStorage.getItem("current_user")); 
        var add_meal = $http.get(apiUrl + '?func=deleteMealrange&sec_token=YHDgjy9Q7yuDFgTE&user_option='+delmeal.useroption+'&meal_time='+delmeal.mealtime+'&id='+delmeal.meal_id+'&user_id='+currentuser.userId+'&org_id='+currentuser.orgId).then(function(response){
          return response.data;
        });
        return add_meal;
      }

      data.selectedEventdates = function(selecteventid,singledate) {
        var currentuser    = JSON.parse(localStorage.getItem("current_user"));
        var selected_event = $http.get(apiUrl + '?func=selectedEventRange&sec_token=YHDgjy9Q7yuDFgTE&id='+selecteventid+'&eventdate='+singledate+'&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return selected_event;
      }

      data.selectedEventdates_thirdParty = function(selecteventid) {
        var selected_event = $http.get(thirdPartyUrl+"/get_single_event_data?api_key=10cf93697d7155ac0d368bbafbc842a4&event_id="+selecteventid).then(function(response){
          return response.data;
        });
        return selected_event;
      }

      data.selectedMealdates = function(mealid,weekday) {
        var currentuser   = JSON.parse(localStorage.getItem("current_user"));
        var selected_meal = $http.get(apiUrl + '?func=selectedMealRange&sec_token=YHDgjy9Q7yuDFgTE&id='+mealid+'&week_day='+weekday+'&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return selected_meal;
      }

      data.singleEvent = function(singleevent){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        // console.log("Single Event Details :"+JSON.stringify(singleevent));
        var single ;
        if(singleevent.thirdparty_access == 1)
        {
          single = $http.get(thirdPartyUrl+"/get_single_event_data?api_key=10cf93697d7155ac0d368bbafbc842a4&event_id="+singleevent.id).then(function(response){
            return response.data;
          }); 
        }
        else
        {
          single = $http.get(apiUrl +'?func=singleEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+singleevent.id).then(function(response){
            return response.data;
          });  
        }
        return single;
      }
      
      data.singleEventloc = function(eventid){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var single = $http.get(apiUrl +'?func=singleEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+eventid).then(function(response){
          return response.data;
        });
        return single;
      }
      
      data.singleMeal = function(singlemeal){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var singleMeal = $http.get(apiUrl +'?func=singleMeal&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+singlemeal.id).then(function(response){
          return response.data;
        });
        return singleMeal;
      }

      data.singleMyDay = function(singledate){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var singleday = $http.get(apiUrl +'?func=singleMyDay&sec_token=YHDgjy9Q7yuDFgTE&user_id='+currentuser.userId+'&eventdate='+singledate).then(function(response){
          return response.data;
        });
        return singleday;
      }

      data.joinEventUserlist = function(joineventuser){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinEvent = $http.get(apiUrl + '?func=joinEventUserList&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joineventuser.id+'&singledate='+joineventuser.singledate).then(function(response){
          return response.data;
        });
        return joinEvent;
      }

      data.joinMealUserlist = function(joinmealuser){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinMeal = $http.get(apiUrl + '?func=joinMealUserList&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joinmealuser.id+'&resident_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return joinMeal;
      }

      data.joinEvent = function(joinevent){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinevent = $http.get(apiUrl + '?func=joinEvent&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joinevent.id+'&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return joinevent;
      }

      data.joinMeal = function(joinmeal){
        var currentuser = JSON.parse(localStorage.getItem("current_user"));
        var joinmeal = $http.get(apiUrl + '?func=joinMeal&sec_token=YHDgjy9Q7yuDFgTE&org_id='+currentuser.orgId+'&id='+joinmeal.id+'&user_id='+currentuser.userId).then(function(response){
          return response.data;
        });
        return joinmeal;
      }
    return data;
  });

})();
