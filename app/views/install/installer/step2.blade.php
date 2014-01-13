@extends('install.layouts.default')

@section('title')
{{ Lang::get('install/installer.installer') }} | {{ Lang::get('install/installer.step') }} 2 {{ Lang::get('install/installer.of') }} 5
@stop
@section('content')
<div id="install-region">
	@if (Session::has('install_errors'))
	<div class="alert alert-block alert-error">
		<strong>{{ Lang::get('install/installer.error') }}</strong>
		@foreach ($errors->all() as $error)
		<li>
			{{ $error }}
		</li>
		@endforeach
	</div>
	@endif
	<form method="post" action="{{ url('install/step2') }}" class="form-horizontal">
		
<p><h5>1. Please configure your PHP settings to match requirements listed below.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">PHP Settings</th>
                <th>Current Settings</th>
                <th>Required Settings</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>PHP Version:</td>
                <td class="align_center"><?php echo phpversion(); ?></td>
                <td class="align_center">5.1.6+</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . ((phpversion() >= '5.1.6') ? 'good' : 'bad').png')}}" /></td>
            </tr>
            <tr>
                <td>Register Globals:</td>
                <td class="align_center">{{ (ini_get('register_globals')) ? 'On' : 'Off'}}</td>
                <td class="align_center">Off</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . (( ! ini_get('register_globals')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
            <tr>
                <td>Magic Quotes GPC:</td>
                <td class="align_center">{{ (ini_get('magic_quotes_gpc')) ? 'On' : 'Off'}}</td>
                <td class="align_center">Off</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . (( ! ini_get('magic_quotes_gpc')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
            <tr>
                <td>File Uploads:</td>
                <td class="align_center">{{ (ini_get('file_uploads')) ? 'On' : 'Off'}}</td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . ((ini_get('file_uploads')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
            <tr>
                <td>Session Auto Start:</td>
                <td class="align_center">{{ (ini_get('session_auto_start')) ? 'On' : 'Off'}}</td>
                <td class="align_center">Off</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . (( ! ini_get('session_auto_start')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5>2. Please make sure the extensions listed below are installed.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Extension</th>
                <th>Current Settings</th>
                <th>Required Settings</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MySQL:</td>
                <td class="align_center">{{ extension_loaded('mysql') ? 'On' : 'Off'}}</td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . ((extension_loaded('mysql')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
            <tr>
                <td>GD:</td>
                <td class="align_center">{{ extension_loaded('gd') ? 'On' : 'Off'}}</td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . ((extension_loaded('gd')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
            <tr>
                <td>cURL:</td>
                <td class="align_center">{{ extension_loaded('curl') ? 'On' : 'Off'}}</td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="{{asset('assets/install/img/' . ((extension_loaded('curl')) ? 'good' : 'bad').png')}}" /></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5>3. Please make sure you have set the correct permissions on the files list below.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Files</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo CMS_ROOT . 'application/config/config.php'; ?></td>
                <td class="align_center"><?php echo is_writable(CMS_ROOT . 'application/config/config.php') ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
            <tr>
                <td><?php echo CMS_ROOT . 'application/config/database.php'; ?></td>
                <td class="align_center"><?php echo is_writable(CMS_ROOT . 'application/config/database.php') ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5>4. Please make sure you have set the correct permissions on the directories list below.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Directories</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($writable_dirs as $path => $is_writable): ?>
            <tr>
                <td><?php echo CMS_ROOT . $path; ?></td>
                <td class="align_center"><?php echo $is_writable ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn save">
					{{ Lang::get('install/installer.next_step') }}
				</button>
			</div>
		</div>
	</form>
</div>
@stop


