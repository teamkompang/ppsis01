@auth
<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
		</div>
		<div class="header-right">
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="icon-copy dw dw-user2"></i>
						{{ Auth::user()->fullname }}
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="right-sidebar">
		<div class="sidebar-title">
			<h3 class="weight-600 font-16 text-blue">
				User Side
			</h3>
			<div class="close-sidebar" data-toggle="right-sidebar-close">
				<i class="icon-copy ion-close-round"></i>
			</div>
		</div>
		<div class="right-sidebar-body customscroll">
			<div class="right-sidebar-body-content">
				<h4 class="weight-600 font-18 pb-10">{{ Auth::user()->fullname }}</h4>
					@can('all_profilemaintain-list')
					<a class="dropdown-item" href="{{ route('profilemaintain.edit',auth()->user()->id)}}"><i class="dw dw-user1"></i> Profile</a>
					@endcan
                    
                    <!-- <a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a>
                    <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> -->
                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();"><i class="dw dw-logout"></i>
													  Log Out
													  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
															@csrf
														</form>
													</a>
			</div>
		</div>
	</div>
@endauth