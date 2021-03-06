@extends('skins.neverland.admin.layout')

@section('module')
	<section id="admin-antispam">
		{{
			Form::open(array(
				'autocomplete'   => 'off',
				'role'           => 'form',
			))
		}}

		<div class="row-fluid">
			<div class="span12">
				<fieldset>
					<legend>{{ Lang::get('admin.spam_filters') }}</legend>

					<ul id="tabs-antispam" class="nav nav-tabs">
						<li class="active">
							<a href="#service-honeypot" data-toggle="tab">{{ Lang::get('admin.honeypot') }}</a>
						</li>

						<li>
							<a href="#service-censor" data-toggle="tab">{{ Lang::get('admin.word_censor') }}</a>
						</li>

						<li>
							<a href="#service-stealth" data-toggle="tab">{{ Lang::get('admin.stealth') }}</a>
						</li>

						<li>
							<a href="#service-noflood" data-toggle="tab">{{ Lang::get('admin.noflood') }}</a>
						</li>

						<li>
							<a href="#service-akismet" data-toggle="tab">{{ Lang::get('admin.akismet') }}</a>
						</li>
					</ul>

					<div class="tab-content form-horizontal">
						<div id="service-honeypot" class="tab-pane fade in active">
							<div class="row-fluid">
								<div class="span12">
									<div class="alert alert-info">
										<p>{{ Lang::get('admin.honeypot_exp') }}</p>

										<div class="checkbox">
											<label>
												{{ Form::checkbox('flag_php', 1, $flags->php) }}
												<strong>{{ Lang::get('admin.enable_filter') }}</strong>
											</label>
										</div>
									</div>

									<div class="alert alert-warning">
										{{ Lang::get('admin.honeypot_more') }}
										{{ link_to('http://www.projecthoneypot.org/httpbl_api.php') }}
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('php_key', Lang::get('admin.access_key'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									{{
										Form::text('php_key', $site->antispam->phpKey, array(
											'class' => 'input-xxlarge',
										))
									}}

									<div class="help-block">
										{{ Lang::get('admin.access_key_exp') }}
										{{ link_to('http://www.projecthoneypot.org/httpbl_configure.php') }}
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('php_days', Lang::get('admin.age_threshold'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									{{
										Form::text('php_days', $site->antispam->phpDays, array(
											'class' => 'input-xxlarge',
										))
									}}

									<div class="help-block">
										{{ Lang::get('admin.age_threshold_exp') }}
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('php_score', Lang::get('admin.threat_score'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									{{
										Form::text('php_score', $site->antispam->phpScore, array(
											'class' => 'input-xxlarge',
										))
									}}

									<div class="help-block">
										{{ Lang::get('admin.threat_score_exp') }}
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('php_type', Lang::get('admin.visitor_filter'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									{{
										Form::text('php_type', $site->antispam->phpType, array(
											'class' => 'input-xxlarge',
										))
									}}

									<div class="help-block">
										{{ Lang::get('admin.visitor_filter_exp') }}
									</div>
								</div>
							</div>
						</div>

						<div id="service-censor" class="tab-pane fade">
							<div class="row-fluid">
								<div class="span12">
									<div class="alert alert-info">
										<p>{{ Lang::get('admin.word_censor_exp') }}</p>

										<div class="checkbox">
											<label>
												{{ Form::checkbox('flag_censor', 1, $flags->censor) }}
												<strong>{{ Lang::get('admin.enable_filter') }}</strong>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('censor', Lang::get('admin.phrases'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									{{
										Form::textarea('censor', $site->antispam->censor, array(
											'class' => 'input-xxlarge',
											'rows'  => 5,
										))
									}}

									<div class="help-block">
										{{ Lang::get('admin.phrases_exp') }}
									</div>
								</div>
							</div>
						</div>

						<div id="service-stealth" class="tab-pane fade">
							<div class="row-fluid">
								<div class="span12">
									<div class="alert alert-info">
										<p>{{ Lang::get('admin.stealth_exp') }}</p>

										<div class="checkbox">
											<label>
												{{ Form::checkbox('flag_stealth', 1, $flags->stealth) }}
												<strong>{{ Lang::get('admin.enable_filter') }}</strong>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div id="service-noflood" class="tab-pane fade">
							<div class="row-fluid">
								<div class="span12">
									<div class="alert alert-info">
										<p>{{ Lang::get('admin.noflood_exp') }}</p>

										<div class="checkbox">
											<label>
												{{ Form::checkbox('flag_noflood', 1, $flags->noflood) }}
												<strong>{{ Lang::get('admin.enable_filter') }}</strong>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('flood_threshold', Lang::get('admin.threshold'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									<div class="input-append">
										{{
											Form::text('flood_threshold', $site->antispam->floodThreshold, array(
												'class' => 'input-xxlarge',
											))
										}}

										<div class="add-on">
											{{ Lang::get('admin.seconds') }}
										</div>
									</div>

									<div class="help-block">
										{{ Lang::get('admin.threshold_exp') }}
									</div>
								</div>
							</div>
						</div>

						<div id="service-akismet" class="tab-pane fade">
							<div class="row-fluid">
								<div class="span12">
									<div class="alert alert-info">
										<p>{{ Lang::get('admin.akismet_exp') }}</p>

										<div class="checkbox">
											<label>
												{{ Form::checkbox('flag_akismet', 1, $flags->akismet) }}
												<strong>{{ Lang::get('admin.enable_filter') }}</strong>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="control-group">
								{{
									Form::label('akismet_key', Lang::get('admin.akismet_key'), array(
										'class' => 'control-label span2'
									))
								}}

								<div class="span9">
									{{
										Form::text('akismet_key', $site->antispam->akismetKey, array(
											'class' => 'input-xxlarge',
										))
									}}

									<div class="help-block">
										{{ Lang::get('admin.akismet_key_exp') }}
										{{ link_to('http://akismet.com') }}
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-actions">
						{{
							Form::submit(Lang::get('admin.save_all'), array(
								'name'    => '_save',
								'class'   => 'btn btn-primary'
							))
						}}
					</div>
				</fieldset>
			</div>
		</div>

		{{ Form::close() }}
	</section>
@stop
