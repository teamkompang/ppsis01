@auth
<div class="left-side-bar">
		<div class="brand-logo">
			<a href="/home">
                <img src="{{ asset('img/logo1.png') }}" alt="" class="light-logo " width="100" height="200">
                <h4 class="weight-600 font-16 text-white">
				     PANEL SOLICITORS
			    </h4>
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li>
						<div class="dropdown-divider"></div>
					</li>
                    <li>
						<a href="/home" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Activity</div>
					</li>
					<li>
						@can('financing')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-calculator"></span><span class="mtext">New Financing</span>
							</a>
							<ul class="submenu">
								@can('punb_financing-list')
									<li><a href="{{ route('punbnewfinancing.index') }}">PUNB Status Update</a></li>
								@endcan
								@can('panel_financing-list')
									<li><a href="{{ route('panelnewfinancing.index') }}">Panel Status Update</a></li>
								@endcan
							</ul>
						@endcan
                    </li>
					<li>
						@can('financing')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit-2"></span><span class="mtext">Financing</span>
							</a>
							<ul class="submenu">
								@can('punb_financing-list')
									<li><a href="{{ route('punbfinancing.index') }}">PUNB Status Update</a></li>
								@endcan
								@can('panel_financing-list')
									<li><a href="{{ route('panelfinancing.index') }}">Panel Status Update</a></li>
								@endcan
							</ul>
						@endcan
                    </li>
                    <li>
						@can('restructure')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-flow"></span><span class="mtext">Restructure</span>
							</a>
							<ul class="submenu">
								@can('punb_restructure-list')
									<li><a href="{{ route('punbrestructure.index') }}">PUNB Status Update</a></li>
								@endcan
								@can('panel_restructure-list')
									<li><a href="{{ route('panelrestructure.index') }}">Panel Status Update</a></li>
								@endcan
							</ul>
						@endcan
                    </li>
                    <li>
						@can('reinstate')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-book"></span><span class="mtext">Reinstate</span>
							</a>
							<ul class="submenu">
								@can('punb_reinstate-list')
									<li><a href="{{ route('punbreinstate.index') }}">PUNB Status Update</a></li>
								@endcan
								@can('panel_reinstate-list')
									<li><a href="{{ route('panelreinstate.index') }}">Panel Status Update</a></li>
								@endcan
							</ul>
						@endcan
                    </li>
                    <li>
						@can('vlo')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-newspaper-1"></span><span class="mtext">VLO</span>
							</a>
							<ul class="submenu">
								@can('punb_vlo-list')
									<li><a href="{{ route('punbvlo.index') }}">PUNB Status Update</a></li>
								@endcan
								@can('panel_vlo-list')
									<li><a href="{{ route('panelvlo.index') }}">Panel Status Update</a></li>
								@endcan
							</ul>
						@endcan
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Settings</div>
                    </li>
                    <li>
						@can('maintenance')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-settings"></span><span class="mtext">Maintenance</span>
							</a>
							<ul class="submenu">
								@can('punb_casestatus-list')
									<li><a href="{{ route('casestatus.index') }}">Case Status</a></li>
								@endcan
								@can('punb_panelstatus-list')
									<li><a href="{{ route('panelstatus.index') }}">Panel Status</a></li>
								@endcan
							</ul>
						@endcan
                    </li>
                    <li>
						@can('security')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-shield1"></span><span class="mtext">Security</span>
							</a>
							<ul class="submenu">
								@can('all_profilemaintain-list')
									<li><a href="{{ route('profilemaintain.edit',auth()->user()->id)}}">Profile Maintenance</a></li>
								@endcan
								@can('admin_usermaintain-list')
									<li><a href="{{ route('usermaintain.index') }}">User Maintenance</a></li>
								@endcan
								@can('admin_role-list')
									<li><a href="{{ route('roles.index') }}">Role Maintenance</a></li>
								@endcan
								@can('admin_security-list')
									<li><a href="{{ route('securesetting.index') }}">Security Setting</a></li>
								@endcan
								@can('admin_parameter-list')
									<li><a href="{{ route('paramsetting.index') }}">Parameter Setting</a></li>
								@endcan	
								@can('admin_parameter-list')
									<li><a href="{{ route('emailcase.index') }}">Email Cases</a></li>
								@endcan	
							</ul>
						@endcan	
                    </li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Report</div>
					</li>
					<li>
						@can('report')
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-file4"></span><span class="mtext">Report</span>
							</a>
							<ul class="submenu">
								@can('report_all-list')
									<li><a href="{{ route('report.index') }}">Report</a></li>
								@endcan
							</ul>
						@endcan
                    </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>
	@endauth