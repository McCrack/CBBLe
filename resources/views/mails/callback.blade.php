<div style="max-width: 680px">
	<div style="text-align:center;padding: 10px;background-color:crimson;color:white">
		<h1>{{ config('app.name') }} Callback</h1>
	</div>
	
	<table width="100%" cellspacing="0" cellpadding="8">
		<tbody>
			<tr align="left">
				<td width="150px">{{ $dictionary->name }}:</td>
				<th>{{ $request->name }}</th>
			</tr>
			<tr align="left" bgcolor="#F3F3F3">
				<td>{{ $dictionary->phone }}:</td>
				<th><a href="tel:{{ $request->phone }}">{{ $request->phone }}</a></th>
			</tr>
		</tbody>
	</table>
	<div style="padding:15px 10px;border:1px solid #CCC;border-radius:3px">
		<h4 style="margin:0">{{ $dictionary->comment }}</h4>
		<p>
		{{ $request->message }}
		</p>
	</div>
</div>