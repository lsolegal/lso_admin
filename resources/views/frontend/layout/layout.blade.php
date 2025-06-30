<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
  <!-- Title -->
  <title>Chrev Laravel | Dashboard</title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="DexignZone">
  <meta name="robots" content="">

  <meta name="keywords"
    content="admin dashboard, admin template, administration, analytics, bootstrap, crypto, trade, crypto admin, trade dashboard, modern, responsive admin dashboard">
  <meta name="description"
    content="Unlock the potential of cryptocurrency management with Chrev- The Crypto Admin Template. Seamlessly manage your digital assets, track market trends, and stay ahead in the world of blockchain with this feature-packed admin template. Dive into the future of finance today.">
  <meta property="og:title" content="Chrev - Crypto Bootstrap Admin Dashboard">
  <meta property="og:description"
    content="Unlock the potential of cryptocurrency management with Chrev- The Crypto Admin Template. Seamlessly manage your digital assets, track market trends, and stay ahead in the world of blockchain with this feature-packed admin template. Dive into the future of finance today.">
  <meta property="og:image" content="../social-image.html">
  <meta name="format-detection" content="telephone=no">

  <!-- Mobile Specific -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon.png">

  @include('frontend/layout/css')
</head>

<body>
  <div id="preloader">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  <div id="main-wrapper" class="menu-toggle">
    <div class="nav-header">
      <a href="{{ url('/') }}" class="brand-logo">
        <svg class="logo-abbr" width="52" height="52" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="svg-logo-primary-path" fill="url(#paint0_linear)" d="M0 0h52v52H0z" />
          <path class="svg-icon-text"
            d="M14 24.708c0-1.536.288-3.06.864-4.572.576-1.536 1.416-2.904 2.52-4.104 1.104-1.2 2.448-2.172 4.032-2.916C23 12.372 24.8 12 26.816 12c2.4 0 4.476.516 6.228 1.548 1.776 1.032 3.096 2.376 3.96 4.032l-4.536 3.168c-.288-.672-.66-1.224-1.116-1.656-.432-.456-.912-.816-1.44-1.08-.528-.288-1.068-.48-1.62-.576-.552-.12-1.092-.18-1.62-.18-1.128 0-2.112.228-2.952.684-.84.456-1.536 1.044-2.088 1.764s-.96 1.536-1.224 2.448c-.264.912-.396 1.836-.396 2.772 0 1.008.156 1.98.468 2.916.312.936.756 1.764 1.332 2.484.6.72 1.308 1.296 2.124 1.728.84.408 1.776.612 2.808.612.528 0 1.068-.06 1.62-.18.576-.144 1.116-.348 1.62-.612.528-.288 1.008-.648 1.44-1.08.432-.456.78-1.008 1.044-1.656l4.824 2.844c-.384.936-.96 1.776-1.728 2.52-.744.744-1.608 1.368-2.592 1.872s-2.028.888-3.132 1.152c-1.104.264-2.184.396-3.24.396-1.848 0-3.552-.372-5.112-1.116-1.536-.768-2.868-1.776-3.996-3.024-1.104-1.248-1.968-2.664-2.592-4.248-.6-1.584-.9-3.192-.9-4.824z"
            fill="white" />
          <path class="svg-icon-text" d="M11 12h15v3H11v-3zM6 24h19v2H6v-2zM15 34h19v2H15v-2z" fill="white" />
          <path d="M6 24h9v1H6v-1z" fill="white" />
          <defs>
            <linearGradient id="paint0_linear" x1="26" y1="0" x2="44" y2="62.5" gradientUnits="userSpaceOnUse">
              <stop offset="1" stop-color="#6418C3" />
              <stop offset="1" stop-color="#6418C3" />
            </linearGradient>
          </defs>
        </svg>

        <svg class="brand-title" width="80" height="22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="svg-logo-text"
            d="M.756 10.892c0-1.19467.224-2.38.672-3.556.448-1.176 1.10133-2.24 1.96-3.192s1.904-1.708 3.136-2.268c1.232-.57867 2.632-.868 4.2-.868 1.848 0 3.4627.40133 4.844 1.204 1.3813.80267 2.408 1.848 3.08 3.136L15.12 7.812c-.2987-.69067-.7-1.232-1.204-1.624-.504-.41067-1.0453-.69067-1.624-.84-.5787-.168-1.1387-.252-1.68-.252-1.176 0-2.14667.29867-2.912.896-.76533.59733-1.33467 1.35333-1.708 2.268-.37333.91467-.56 1.848-.56 2.8 0 1.0453.21467 2.0347.644 2.968.42933.9147 1.036 1.652 1.82 2.212.784.56 1.708.84 2.772.84.56 0 1.1293-.084 1.708-.252.5787-.1867 1.1107-.4853 1.596-.896.504-.4107.8867-.9427 1.148-1.596l3.752 2.212c-.392.9893-1.036 1.8293-1.932 2.52-.896.672-1.9133 1.1947-3.052 1.568-1.12.3547-2.2307.532-3.332.532-1.43733 0-2.75333-.2893-3.948-.868-1.19467-.5973-2.23067-1.3813-3.108-2.352-.87733-.9893-1.55867-2.0907-2.044-3.304-.466667-1.232-.7-2.4827-.7-3.752zM34.9853 21h-4.48v-8.26c0-.952-.196-1.652-.588-2.1-.3733-.448-.8773-.672-1.512-.672-.5226 0-1.1106.2427-1.764.728-.6346.4667-1.0826 1.092-1.344 1.876V21h-4.48V.559999h4.48V8.764c.5227-.87733 1.232-1.54933 2.128-2.016.896-.48533 1.876-.728 2.94-.728.9894 0 1.792.168 2.408.504.616.336 1.0827.784 1.4 1.344.3174.54133.532 1.13867.644 1.792.112.6533.168 1.2973.168 1.932V21zm12.3006-10.864c-1.0827.0187-2.0627.196-2.94.532-.8774.336-1.512.84-1.904 1.512V21h-4.48V6.3h4.116v2.968c.504-.98933 1.1573-1.764 1.96-2.324.8026-.56 1.6426-.84933 2.52-.868.3733 0 .616.00933.728.028v4.032zm8.8055 11.144c-1.6613 0-3.08-.3453-4.256-1.036-1.176-.6907-2.0813-1.6053-2.716-2.744-.616-1.1387-.924-2.3707-.924-3.696 0-1.4187.308-2.716.924-3.892.616-1.176 1.512-2.11867 2.688-2.828 1.176-.70933 2.604-1.064 4.284-1.064 1.6614 0 3.08.35467 4.256 1.064 1.176.70933 2.0627 1.64267 2.66 2.8.616 1.1573.924 2.3987.924 3.724 0 .5413-.0373 1.0173-.112 1.428h-10.864c.0747.9893.4294 1.7453 1.064 2.268.6534.504 1.3907.756 2.212.756.6534 0 1.2787-.1587 1.876-.476.5974-.3173 1.008-.7467 1.232-1.288l3.808 1.064c-.5786 1.1573-1.484 2.1-2.716 2.828-1.2133.728-2.66 1.092-4.34 1.092zm-3.248-8.988h6.384c-.0933-.9333-.4386-1.6707-1.036-2.212-.5786-.56-1.2973-.84-2.156-.84-.8586 0-1.5866.28-2.184.84-.5786.56-.9146 1.2973-1.008 2.212zM69.3324 21l-5.208-14.7h4.62l3.22 10.668 3.22-10.668h4.2l-5.18 14.7h-4.872z"
            fill="#3C4469" />
        </svg>
      </a>
      
      <div class="nav-control">
        {{-- sidebar toggle icon --}}
        @if (session()->has('get_kundli'))
          <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
          </div>
        @endif
      </div>
    </div>
    <div class="chatbox">
      <div class="chatbox-close"></div>
      <div class="custom-tab-1">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#notes">Notes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#alerts">Alerts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#chat">Chat</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active show" id="chat" role="tabpanel">
            <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
              <div class="card-header chat-list-header text-center">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                      <rect fill="#000000" opacity="0.3"
                        transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                        x="4" y="11" width="16" height="2" rx="1" />
                    </g>
                  </svg></a>
                <div>
                  <h6 class="mb-1">Chat List</h6>
                  <p class="mb-0">Show All</p>
                </div>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24" />
                      <circle fill="#000000" cx="5" cy="12" r="2" />
                      <circle fill="#000000" cx="12" cy="12" r="2" />
                      <circle fill="#000000" cx="19" cy="12" r="2" />
                    </g>
                  </svg></a>
              </div>
              <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">
                <ul class="contacts">
                  <li class="name-first-letter">A</li>
                  <li class="active dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/1.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon"></span>
                      </div>
                      <div class="user_info">
                        <span>Archie Parker</span>
                        <p>Kalid is online</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/2.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Alfie Mason</span>
                        <p>Taherah left 7 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/3.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon"></span>
                      </div>
                      <div class="user_info">
                        <span>AharlieKane</span>
                        <p>Sami is online</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/4.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Athan Jacoby</span>
                        <p>Nargis left 30 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="name-first-letter">B</li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/5.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Bashid Samim</span>
                        <p>Rashid left 50 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/1.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon"></span>
                      </div>
                      <div class="user_info">
                        <span>Breddie Ronan</span>
                        <p>Kalid is online</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/2.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Ceorge Carson</span>
                        <p>Taherah left 7 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="name-first-letter">D</li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/3.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon"></span>
                      </div>
                      <div class="user_info">
                        <span>Darry Parker</span>
                        <p>Sami is online</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/4.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Denry Hunter</span>
                        <p>Nargis left 30 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="name-first-letter">J</li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/5.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Jack Ronan</span>
                        <p>Rashid left 50 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/1.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon"></span>
                      </div>
                      <div class="user_info">
                        <span>Jacob Tucker</span>
                        <p>Kalid is online</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/2.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>James Logan</span>
                        <p>Taherah left 7 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/3.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon"></span>
                      </div>
                      <div class="user_info">
                        <span>Joshua Weston</span>
                        <p>Sami is online</p>
                      </div>
                    </div>
                  </li>
                  <li class="name-first-letter">O</li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/4.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Oliver Acker</span>
                        <p>Nargis left 30 mins ago</p>
                      </div>
                    </div>
                  </li>
                  <li class="dz-chat-user">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont">
                        <img src="public/images/avatar/5.jpg" class="rounded-circle user_img" alt="" />
                        <span class="online_icon offline"></span>
                      </div>
                      <div class="user_info">
                        <span>Oscar Weston</span>
                        <p>Rashid left 50 mins ago</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card chat dz-chat-history-box d-none">
              <div class="card-header chat-list-header text-center">
                <a href="#" class="dz-chat-history-back">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                    height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <polygon points="0 0 24 0 24 24 0 24" />
                      <rect fill="#000000" opacity="0.3"
                        transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) "
                        x="14" y="7" width="2" height="10" rx="1" />
                      <path
                        d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z"
                        fill="#000000" fill-rule="nonzero"
                        transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) " />
                    </g>
                  </svg>
                </a>
                <div>
                  <h6 class="mb-1">Chat with Khelesh</h6>
                  <p class="mb-0 text-success">Online</p>
                </div>
                <div class="dropdown">
                  <a href="#" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24"
                      version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" cx="5" cy="12" r="2" />
                        <circle fill="#000000" cx="12" cy="12" r="2" />
                        <circle fill="#000000" cx="19" cy="12" r="2" />
                      </g>
                    </svg></a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i>
                      View profile</li>
                    <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to
                      close friends</li>
                    <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to
                      group</li>
                    <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li>
                  </ul>
                </div>
              </div>
              <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body3">
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    Hi, how are you samim?
                    <span class="msg_time">8:40 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                  <div class="msg_cotainer_send">
                    Hi Khalid i am good tnx how about you?
                    <span class="msg_time_send">8:55 AM, Today</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    I am good too, thank you for your chat template
                    <span class="msg_time">9:00 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                  <div class="msg_cotainer_send">
                    You are welcome
                    <span class="msg_time_send">9:05 AM, Today</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    I am looking for your next templates
                    <span class="msg_time">9:07 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                  <div class="msg_cotainer_send">
                    Ok, thank you have a good day
                    <span class="msg_time_send">9:10 AM, Today</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    Bye, see you
                    <span class="msg_time">9:12 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    Hi, how are you samim?
                    <span class="msg_time">8:40 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                  <div class="msg_cotainer_send">
                    Hi Khalid i am good tnx how about you?
                    <span class="msg_time_send">8:55 AM, Today</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    I am good too, thank you for your chat template
                    <span class="msg_time">9:00 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                  <div class="msg_cotainer_send">
                    You are welcome
                    <span class="msg_time_send">9:05 AM, Today</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    I am looking for your next templates
                    <span class="msg_time">9:07 AM, Today</span>
                  </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                  <div class="msg_cotainer_send">
                    Ok, thank you have a good day
                    <span class="msg_time_send">9:10 AM, Today</span>
                  </div>
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                </div>
                <div class="d-flex justify-content-start mb-4">
                  <div class="img_cont_msg">
                    <img src="public/images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="" />
                  </div>
                  <div class="msg_cotainer">
                    Bye, see you
                    <span class="msg_time">9:12 AM, Today</span>
                  </div>
                </div>
              </div>
              <div class="card-footer type_msg">
                <div class="input-group">
                  <textarea class="form-control" placeholder="Type your message..."></textarea>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary"><i class="fa fa-location-arrow"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="alerts" role="tabpanel">
            <div class="card mb-sm-3 mb-md-0 contacts_card">
              <div class="card-header chat-list-header text-center">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24" />
                      <circle fill="#000000" cx="5" cy="12" r="2" />
                      <circle fill="#000000" cx="12" cy="12" r="2" />
                      <circle fill="#000000" cx="19" cy="12" r="2" />
                    </g>
                  </svg></a>
                <div>
                  <h6 class="mb-1">Notications</h6>
                  <p class="mb-0">Show All</p>
                </div>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24" />
                      <path
                        d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                      <path
                        d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                        fill="#000000" fill-rule="nonzero" />
                    </g>
                  </svg></a>
              </div>
              <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body1">
                <ul class="contacts">
                  <li class="name-first-letter">SEVER STATUS</li>
                  <li class="active">
                    <div class="d-flex bd-highlight">
                      <div class="img_cont primary">KK</div>
                      <div class="user_info">
                        <span>David Nester Birthday</span>
                        <p class="text-primary">Today</p>
                      </div>
                    </div>
                  </li>
                  <li class="name-first-letter">SOCIAL</li>
                  <li>
                    <div class="d-flex bd-highlight">
                      <div class="img_cont success">RU</div>
                      <div class="user_info">
                        <span>Perfection Simplified</span>
                        <p>Jame Smith commented on your status</p>
                      </div>
                    </div>
                  </li>
                  <li class="name-first-letter">SEVER STATUS</li>
                  <li>
                    <div class="d-flex bd-highlight">
                      <div class="img_cont primary">AU</div>
                      <div class="user_info">
                        <span>AharlieKane</span>
                        <p>Sami is online</p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex bd-highlight">
                      <div class="img_cont info">MO</div>
                      <div class="user_info">
                        <span>Athan Jacoby</span>
                        <p>Nargis left 30 mins ago</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="card-footer"></div>
            </div>
          </div>
          <div class="tab-pane fade" id="notes">
            <div class="card mb-sm-3 mb-md-0 note_card">
              <div class="card-header chat-list-header text-center">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                      <rect fill="#000000" opacity="0.3"
                        transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                        x="4" y="11" width="16" height="2" rx="1" />
                    </g>
                  </svg></a>
                <div>
                  <h6 class="mb-1">Notes</h6>
                  <p class="mb-0">Add New Nots</p>
                </div>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24" />
                      <path
                        d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                      <path
                        d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                        fill="#000000" fill-rule="nonzero" />
                    </g>
                  </svg></a>
              </div>
              <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body2">
                <ul class="contacts">
                  <li class="active">
                    <div class="d-flex bd-highlight">
                      <div class="user_info">
                        <span>New order placed..</span>
                        <p>10 Aug 2020</p>
                      </div>
                      <div class="ms-auto">
                        <a href="#" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                        <a href="#" class="btn btn-danger btn-xs sharp"><i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex bd-highlight">
                      <div class="user_info">
                        <span>Youtube, a video-sharing website..</span>
                        <p>10 Aug 2020</p>
                      </div>
                      <div class="ms-auto">
                        <a href="#" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                        <a href="#" class="btn btn-danger btn-xs sharp"><i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex bd-highlight">
                      <div class="user_info">
                        <span>john just buy your product..</span>
                        <p>10 Aug 2020</p>
                      </div>
                      <div class="ms-auto">
                        <a href="#" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                        <a href="#" class="btn btn-danger btn-xs sharp"><i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex bd-highlight">
                      <div class="user_info">
                        <span>Athan Jacoby</span>
                        <p>10 Aug 2020</p>
                      </div>
                      <div class="ms-auto">
                        <a href="#" class="btn btn-primary btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                        <a href="#" class="btn btn-danger btn-xs sharp"><i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('frontend/layout/header')

    @if(session()->has('get_kundli'))
      @include('frontend/layout/sidebar')
    @endif

    {{-- content-body default-height --}}
    <div class="{{ session()->has('get_kundli') ? 'content-body default-height' : 'pt-5 mt-5' }}">
      @yield('section')
    </div>
    @include('frontend.layout.footer')
  </div>
  @include('frontend.layout.js')
</body>

<!-- Mirrored from chrev.dexignzone.com/laravel/demo/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Feb 2025 05:16:13 GMT -->

</html>