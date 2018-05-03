@extends('Admin::layouts.template')

@section('body')

<div class="row">
    {{-- <div class="col-sm-5"> --}}
    <div class="col-sm-6">
        <div class="widget-box transparent">
			<div class="widget-header widget-header-flat">
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-bar-chart-o blue"></i>
				Summary
			</h4>
			<div class="widget-toolbar hide">
				<a href="#" data-action="collapse">
				<i class="ace-icon fa fa-chevron-up"></i>
				</a>
			</div>
			</div>
            <div class="widget-body">
                <div id="faq-tab-1" class="tab-pane fade active in">
                    <div class="space-8"></div>
                    <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
						<div class="panel panel-default">
							<div class="panel-heading">
								<a href="#faq-1-4" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle" aria-expanded="true">
									<i class="ace-icon fa fa-chevron-down pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
									<i class="ace-icon fa fa-leaf bigger-130"></i>
									&nbsp; Participants
								</a>
							</div>
							<div class="panel-collapse collapse in" id="faq-1-4" aria-expanded="true">
								<div class="panel-body">
									<table class="table table-striped table-bordered table-hover">
										<thead class="thin-border-bottom">
											<tr>
												<th><i class="ace-icon fa fa-user"></i>Name</th>
												<th><i>@</i> Participant</th>
												{{-- <th><i class="ace-icon fa fa-phone"></i>Phone</th> --}}
												<th class="hidden-480"><i class="ace-icon fa fa-inbox"></i>Created At</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($participants->where('created_at','<', Carbon::now())->orderBy('created_at','desc')->take(3)->get() as $participant)
												<tr>
													<td class="text-info">{{ ($participant->name) ? $participant->name : $participant->first_name .' '.$participant->last_name }}</td>
													<td>{{ $participant->email }}</td>
													{{-- <td class="green">{{ $participant->phone_number }}</td> --}}
													<td class="hidden-480">
														<span class="label label-warning label-sm">{{ $participant->created_at}}</span>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									<span class="pull-right text-primary">
										<i class="glyphicon glyphicon-ok"></i>&nbsp;
										<a href="{{route('admin.participants.index')}}">See Participants ({{ $participants->all()->count() }})</a>
									</span>
								</div>
							</div>
						</div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="#faq-1-2" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">
                                    <i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                    <i class="ace-icon fa fa-pencil-square-o bigger-130"></i>
                                    &nbsp; News 
                                </a>
                            </div>
                            <div class="panel-collapse collapse" id="faq-1-2" aria-expanded="false">
                                <div class="panel-body">
                                    <div id="faq-list-nested-1" class="panel-group accordion-style1 accordion-style2">
                                        <?php
                                        $f = 0;                                        
                                        ?>
                                        @foreach ($news->with('user')->where('created_at','<', Carbon::now())->orderBy('created_at','desc')->take(3)->get() as $row)
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <a href="#faq-list-1-sub-{{$f}}" data-parent="#faq-list-nested-{{$f}}" data-toggle="collapse" class="accordion-toggle collapsed">
                                                        <i class="ace-icon fa fa-plus smaller-80 middle" data-icon-hide="ace-icon fa fa-minus" data-icon-show="ace-icon fa fa-plus"></i>&nbsp;
                                                        {{ str_limit($row->name,48,'--') }}
                                                    </a>
                                                </div>
                                                <div class="panel-collapse collapse" id="faq-list-1-sub-{{$f}}">
                                                    <div class="panel-body">
                                                        {{ str_limit(strip_tags($row->description),'100') }}
                                                        <span class="clearfix lighter green">By : {{$row->user->email}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                            $f++;
                                            ?>
                                        @endforeach
                                        <div class="space-6"></div>
                                        <span class="pull-right text-primary">
                                            <i class="glyphicon glyphicon-ok"></i>&nbsp;
                                            <a href="{{route('admin.news.index')}}">See News ({{ $row->all()->count() }})</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
						</div>

                        <div class="panel panel-default">
							<div class="panel-heading">
								<a href="#faq-1-1" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">
									<i class="pull-right ace-icon fa fa-chevron-left" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
									<i class="ace-icon fa fa-users bigger-130"></i>
									&nbsp; Users
								</a>
							</div>
							<div class="panel-collapse collapse" id="faq-1-1" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<span class="label label-info arrowed arrowed-right">
										{{ $user->where('status',1)->count() }} {{ config('setting.status')[1] }}
									</span>
									<span class="label label-warning arrowed arrowed-right">
										{{ $user->where('status',2)->count() }} {{ config('setting.status')[2] }}
									</span>
									<span class="pull-right text-primary">
										<i class="glyphicon glyphicon-ok"></i>&nbsp;
										<a href="{{route('admin.users.index')}}">See Users ({{ $user->all()->count() }})</a>
									</span>
									<div class="space-4"></div>
									<span class="text-success">Last Login :</span>
									<div class="space-2"></div>
									<table class="table table-striped table-bordered table-hover">
										<thead class="thin-border-bottom">
											<tr>
												<th><i class="ace-icon fa fa-user"></i>User</th>
												<th><i>@</i> Email</th>
												<th class="hidden-480"><i class="ace-icon fa fa-key"></i>Last Login</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($user->where('last_login','<', Carbon::now())->orderBy('last_login','desc')->take(3)->get() as $last)
												<tr>
													<td class="text-info">{{ ($last->username) ? $last->username : $last->email }}</td>
													<td><span class="text-success">{{ $last->email }}</span></td>
													<td class="hidden-480">
														<span class="label label-warning label-sm">{{ $last->last_login}}</span>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
							
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="#faq-1-5" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">
                                    <i class="ace-icon fa fa-chevron-left pull-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-left"></i>
                                    <i class="ace-icon fa fa-exchange bigger-130"></i>
                                    &nbsp; Logs
                                </a>
                            </div>
                            <div class="panel-collapse collapse" id="faq-1-5" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="thin-border-bottom">
                                            <tr>
                                                <th><i class="ace-icon fa fa-user"></i>User</th>
                                                <th><i>@</i> Description</th>
                                                {{-- <th><i class="ace-icon fa fa-phone"></i>Phone</th> --}}
                                                <th class="hidden-480"><i class="ace-icon fa fa-inbox"></i>logged At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($log->with('user')->where('created_at','<', Carbon::now())->orderBy('created_at','desc')->take(3)->get() as $logged)
                                                <tr>
                                                    <td class="text-info">{{ $logged->user->email }}</td>
                                                    <td>
                                                    <?php
                                                    $label = ($logged->description == 'processForm') ? 'label-warning' : 'label-success';
                                                    ?>
                                                    @if ($logged->description)
                                                        <span class="label {{$label}} label-sm">{{ $logged->description }}</span>
                                                    @endif
                                                </td>
                                                    {{-- <td class="green">{{ $logged->phone_number }}</td> --}}
                                                    <td class="hidden-480">
                                                        <span class="label label-warning label-sm">{{ $logged->created_at}}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <span class="pull-right text-primary">
                                        <i class="glyphicon glyphicon-ok"></i>&nbsp;
                                        <a href="{{route('admin.logs.index')}}">See Logs ({{ $log->all()->count() }})</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.widget-body -->
        </div>
	</div>
	<div class="col-sm-6">
		<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title lighter smaller">
			<i class="ace-icon fa fa-comment blue"></i>
			Recent Participant
			</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main no-padding">
			<div class="dialogs">			
				<div class="space-12"></div>
				@foreach ($participants->where('created_at','<', Carbon::now())->orderBy('created_at','desc')->take(5)->get() as $participant)
					<div class="itemdiv dialogdiv">
						<div class="user">
							<img alt="{{$participant->email}} Avatar" src="{{ asset('themes/ace-admin/avatars/avatar2.png') }}" />
						</div>
						<div class="body">
							<div class="time">
								<i class="ace-icon fa fa-clock-o"></i>
								<span class="green">
									{{ Carbon::parse($participant->created_at)->diffForHumans(Carbon::now()) }}
								</span>
							</div>	  
							<div class="name">
								<a href="{{ route('admin.participants.show',$participant->id) }}">{{ $participant->email }}</a>
							</div>
							<div class="text">
								{{ @$participant->first_name .' '.@$participant->last_name }}
								<div class="text-right text-muted small bold">Provider @ {{ $participant->provider }}</div>
							</div>	  
							<div class="tools">
								<a href="#" class="btn btn-minier btn-info">
								<i class="icon-only ace-icon fa fa-share"></i>
								</a>
							</div>
						</div>
					</div>
				@endforeach			
			</div>
		</div>	
		<!--div class="col-sm-7">
			<div id="pop_div"></div>
			<?php echo $lava->render('AreaChart', 'Population', 'pop_div') ?>
		</div-->
    <div class="space-6"></div>
</div><!-- /.row -->

<div class="hr hr16 hr-dotted"></div>

<div class="row hide">
  <div class="col-sm-6">
    <div class="widget-box transparent" id="recent-box">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-rss orange"></i>RECENT
        </h4>

        <div class="widget-toolbar no-border">
          <ul class="nav nav-tabs" id="recent-tab">
            <li class="active">
              <a data-toggle="tab" href="#task-tab">Tasks</a>
            </li>

            <li>
              <a data-toggle="tab" href="#member-tab">Members</a>
            </li>

            <li>
              <a data-toggle="tab" href="#comment-tab">Comments</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main padding-4">
          <div class="tab-content padding-8">
            <div id="task-tab" class="tab-pane active">
              <h4 class="smaller lighter green">
                <i class="ace-icon fa fa-list"></i>
                Sortable Lists
              </h4>

              <ul id="tasks" class="item-list">
                <li class="item-orange clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Answering customer questions</span>
                  </label>

                  <div class="pull-right easy-pie-chart percentage" data-size="30" data-color="#ECCB71" data-percent="42">
                    <span class="percent">42</span>%
                  </div>
                </li>

                <li class="item-red clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Fixing bugs</span>
                  </label>

                  <div class="pull-right action-buttons">
                    <a href="#" class="blue">
                      <i class="ace-icon fa fa-pencil bigger-130"></i>
                    </a>

                    <span class="vbar"></span>

                    <a href="#" class="red">
                      <i class="ace-icon fa fa-trash-o bigger-130"></i>
                    </a>

                    <span class="vbar"></span>

                    <a href="#" class="green">
                      <i class="ace-icon fa fa-flag bigger-130"></i>
                    </a>
                  </div>
                </li>

                <li class="item-default clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Adding new features</span>
                  </label>

                  <div class="inline pull-right position-relative dropdown-hover">
                    <button class="btn btn-minier bigger btn-primary">
                      <i class="ace-icon fa fa-cog icon-only bigger-120"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-caret dropdown-close dropdown-menu-right">
                      <li>
                        <a href="#" class="tooltip-success" data-rel="tooltip" title="Mark&nbsp;as&nbsp;done">
                          <span class="green">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                          <span class="red">
                            <i class="ace-icon fa fa-trash-o bigger-110"></i>
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>

                <li class="item-blue clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Upgrading scripts used in template</span>
                  </label>
                </li>

                <li class="item-grey clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Adding new skins</span>
                  </label>
                </li>

                <li class="item-green clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Updating server software up</span>
                  </label>
                </li>

                <li class="item-pink clearfix">
                  <label class="inline">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"> Cleaning up</span>
                  </label>
                </li>
              </ul>
            </div>

            <div id="member-tab" class="tab-pane">
              <div class="clearfix">
                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Bob Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar3.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Bob Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">20 min</span>
                    </div>

                    <div>
                      <span class="label label-warning label-sm">pending</span>

                      <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
                          <i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                          <li>
                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                              <span class="green">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                              <span class="orange">
                                <i class="ace-icon fa fa-times bigger-110"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                              <span class="red">
                                <i class="ace-icon fa fa-trash-o bigger-110"></i>
                              </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Joe Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar2.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Joe Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">1 hour</span>
                    </div>

                    <div>
                      <span class="label label-warning label-sm">pending</span>

                      <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
                          <i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                          <li>
                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                              <span class="green">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                              <span class="orange">
                                <i class="ace-icon fa fa-times bigger-110"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                              <span class="red">
                                <i class="ace-icon fa fa-trash-o bigger-110"></i>
                              </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Jim Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Jim Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">2 hour</span>
                    </div>

                    <div>
                      <span class="label label-warning label-sm">pending</span>

                      <div class="inline position-relative">
                        <button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
                          <i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                          <li>
                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                              <span class="green">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                              <span class="orange">
                                <i class="ace-icon fa fa-times bigger-110"></i>
                              </span>
                            </a>
                          </li>

                          <li>
                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                              <span class="red">
                                <i class="ace-icon fa fa-trash-o bigger-110"></i>
                              </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Alex Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar5.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Alex Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">3 hour</span>
                    </div>

                    <div>
                      <span class="label label-danger label-sm">blocked</span>
                    </div>
                  </div>
                </div>

                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Bob Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar3.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Bob Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">6 hour</span>
                    </div>

                    <div>
                      <span class="label label-success label-sm arrowed-in">approved</span>
                    </div>
                  </div>
                </div>

                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Susan's avatar" src="{{ asset('themes/ace-admin/avatars/avatar1.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Susan</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">yesterday</span>
                    </div>

                    <div>
                      <span class="label label-success label-sm arrowed-in">approved</span>
                    </div>
                  </div>
				</div>
				
                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Phil Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar4.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Phil Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">2 days ago</span>
                    </div>

                    <div>
                      <span class="label label-info label-sm arrowed-in arrowed-in-right">online</span>
                    </div>
                  </div>
                </div>

                <div class="itemdiv memberdiv">
                  <div class="user">
                    <img alt="Alexa Doe's avatar" src="{{ asset('themes/ace-admin/avatars/avatar1.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Alexa Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">3 days ago</span>
                    </div>

                    <div>
                      <span class="label label-success label-sm arrowed-in">approved</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="space-4"></div>

              <div class="center">
                <i class="ace-icon fa fa-users fa-2x green middle"></i>

                &nbsp;
                <a href="#" class="btn btn-sm btn-white btn-info">
                  See all members &nbsp;
                  <i class="ace-icon fa fa-arrow-right"></i>
                </a>
              </div>

              <div class="hr hr-double hr8"></div>
            </div><!-- /.#member-tab -->

            <div id="comment-tab" class="tab-pane">
              <div class="comments">
                <div class="itemdiv commentdiv">
                  <div class="user">
                    <img alt="Bob Doe's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar2.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Bob Doe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="green">6 min</span>
                    </div>

                    <div class="text">
                      <i class="ace-icon fa fa-quote-left"></i>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                    </div>
                  </div>

                  <div class="tools">
                    <div class="inline position-relative">
                      <button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown">
                        <i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                      </button>

                      <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                        <li>
                          <a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                            <span class="green">
                              <i class="ace-icon fa fa-check bigger-110"></i>
                            </span>
                          </a>
                        </li>

                        <li>
                          <a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                            <span class="orange">
                              <i class="ace-icon fa fa-times bigger-110"></i>
                            </span>
                          </a>
                        </li>

                        <li>
                          <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                            <span class="red">
                              <i class="ace-icon fa fa-trash-o bigger-110"></i>
                            </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="itemdiv commentdiv">
                  <div class="user">
                    <img alt="Jennifer's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar1.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Jennifer</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="blue">15 min</span>
                    </div>

                    <div class="text">
                      <i class="ace-icon fa fa-quote-left"></i>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                    </div>
                  </div>

                  <div class="tools">
                    <div class="action-buttons bigger-125">
                      <a href="#">
                        <i class="ace-icon fa fa-pencil blue"></i>
                      </a>

                      <a href="#">
                        <i class="ace-icon fa fa-trash-o red"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="itemdiv commentdiv">
                  <div class="user">
                    <img alt="Joe's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar2.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Joe</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="orange">22 min</span>
                    </div>

                    <div class="text">
                      <i class="ace-icon fa fa-quote-left"></i>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                    </div>
                  </div>

                  <div class="tools">
                    <div class="action-buttons bigger-125">
                      <a href="#">
                        <i class="ace-icon fa fa-pencil blue"></i>
                      </a>

                      <a href="#">
                        <i class="ace-icon fa fa-trash-o red"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="itemdiv commentdiv">
                  <div class="user">
                    <img alt="Rita's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar3.png') }}" />
                  </div>

                  <div class="body">
                    <div class="name">
                      <a href="#">Rita</a>
                    </div>

                    <div class="time">
                      <i class="ace-icon fa fa-clock-o"></i>
                      <span class="red">50 min</span>
                    </div>

                    <div class="text">
                      <i class="ace-icon fa fa-quote-left"></i>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                    </div>
                  </div>

                  <div class="tools">
                    <div class="action-buttons bigger-125">
                      <a href="#">
                        <i class="ace-icon fa fa-pencil blue"></i>
                      </a>

                      <a href="#">
                        <i class="ace-icon fa fa-trash-o red"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="hr hr8"></div>

              <div class="center">
                <i class="ace-icon fa fa-comments-o fa-2x green middle"></i>

                &nbsp;
                <a href="#" class="btn btn-sm btn-white btn-info">
                  See all comments &nbsp;
                  <i class="ace-icon fa fa-arrow-right"></i>
                </a>
              </div>

              <div class="hr hr-double hr8"></div>
            </div>
          </div>
        </div><!-- /.widget-main -->
      </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
  </div><!-- /.col -->

  <div class="col-sm-6">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title lighter smaller">
          <i class="ace-icon fa fa-comment blue"></i>
          Recent Participant
        </h4>
      </div>
      <div class="widget-body">
        <div class="widget-main no-padding">
          <div class="dialogs">
			
				<div class="space-12"></div>
			@foreach ($participants->where('created_at','<', Carbon::now())->orderBy('created_at','desc')->take(5)->get() as $participant)
				<div class="itemdiv dialogdiv">
					<div class="user">
					  <img alt="{{$participant->email}} Avatar" src="{{ asset('themes/ace-admin/avatars/avatar2.png') }}" />
					</div>
					<div class="body">
						<div class="time">
							<i class="ace-icon fa fa-clock-o"></i>
							<span class="green">
								{{ Carbon::parse($participant->created_at)->diffForHumans(Carbon::now()) }}
							</span>
						</div>	  
						<div class="name">
							<a href="{{ route('admin.participants.show',$participant->id) }}">{{ $participant->email }}</a>
						</div>
					  	<div class="text">
						  	{{ @$participant->first_name .' '.@$participant->last_name }}
						  	<div class="text-right text-muted small bold">Provider @ {{ $participant->provider }}</div>
						</div>	  
					  	<div class="tools">
							<a href="#" class="btn btn-minier btn-info">
							<i class="icon-only ace-icon fa fa-share"></i>
							</a>
						</div>
					</div>
				</div>
			@endforeach
			
            <!--div class="itemdiv dialogdiv">
              <div class="user">
                <img alt="Alexa's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar1.png') }}" />
              </div>
              <div class="body">
                <div class="time">
                  <i class="ace-icon fa fa-clock-o"></i>
                  <span class="green">4 sec</span>
                </div>

                <div class="name">
                  <a href="#">Alexa</a>
                </div>
                <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>

                <div class="tools">
                  <a href="#" class="btn btn-minier btn-info">
                    <i class="icon-only ace-icon fa fa-share"></i>
                  </a>
                </div>
              </div>
			</div>
			
            <div class="itemdiv dialogdiv">
              <div class="user">
                <img alt="John's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar.png') }}" />
              </div>
              <div class="body">
                <div class="time">
                  <i class="ace-icon fa fa-clock-o"></i>
                  <span class="blue">38 sec</span>
                </div>
                <div class="name">
                  <a href="#">John</a>
                </div>
                <div class="text">Raw denim you probably haven&#39;t heard of them jean shorts Austin.</div>
                <div class="tools">
                  <a href="#" class="btn btn-minier btn-info">
                    <i class="icon-only ace-icon fa fa-share"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="itemdiv dialogdiv">
              <div class="user">
                <img alt="Bob's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar2.png') }}"/>
              </div>
              <div class="body">
                <div class="time">
                  <i class="ace-icon fa fa-clock-o"></i>
                  <span class="orange">2 min</span>
                </div>
                <div class="name">
                  <a href="#">Bob</a>
                  <span class="label label-info arrowed arrowed-in-right">admin</span>
                </div>
                <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>
                <div class="tools">
                  <a href="#" class="btn btn-minier btn-info">
                    <i class="icon-only ace-icon fa fa-share"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="itemdiv dialogdiv">
              <div class="user">
                <img alt="Jim's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar3.png') }}"/>
              </div>
              <div class="body">
                <div class="time">
                  <i class="ace-icon fa fa-clock-o"></i>
                  <span class="grey">3 min</span>
                </div>
                <div class="name">
                  <a href="#">Jim</a>
                </div>
                <div class="text">Raw denim you probably haven&#39;t heard of them jean shorts Austin.</div>
                <div class="tools">
                  <a href="#" class="btn btn-minier btn-info">
                    <i class="icon-only ace-icon fa fa-share"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="itemdiv dialogdiv">
              <div class="user">
                <img alt="Alexa's Avatar" src="{{ asset('themes/ace-admin/avatars/avatar4.png') }}"/>
              </div>
              <div class="body">
                <div class="time">
                  <i class="ace-icon fa fa-clock-o"></i>
                  <span class="green">4 min</span>
                </div>
                <div class="name">
                  <a href="#">Alexa</a>
                </div>
                <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                <div class="tools">
                  <a href="#" class="btn btn-minier btn-info">
                    <i class="icon-only ace-icon fa fa-share"></i>
                  </a>
                </div>
              </div>
			</div-->
			
          </div>
{{-- 
          <form>
            <div class="form-actions">
              <div class="input-group">
                <input placeholder="Type your message here ..." type="text" class="form-control" name="message" />
                <span class="input-group-btn">
                  <button class="btn btn-sm btn-info no-radius" type="button">
                    <i class="ace-icon fa fa-share"></i>
                    Send
                  </button>
                </span>
              </div>
            </div>
          </form> --}}
        </div><!-- /.widget-main -->
      </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
  </div><!-- /.col -->
</div><!-- /.row -->
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.panel-group .panel-heading a.accordion-toggle').each(function(){ /* do nothing */ }).eq(0).click();
});
</script>
@endpush
@stop