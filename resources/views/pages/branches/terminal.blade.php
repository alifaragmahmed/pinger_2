@extends('layouts.master')

@section('PageTitle', $breadcrumb['title'])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <style>
        .ternimal {
            width: 100%;
            border-radius: 16px;
            background-color: black;
            color: white;
            font-family: consolas;
            font-size: 12px;
            min-height: 300px;
            padding: 20px;
        }
    </style>
@endsection

@section('PageContent')
    @includeIf('layouts.inc.breadcrumb')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card  ">
                <div class="card-header bg-white ">
                    <h5><b>@lang('Shell Commander'):</b></h5>
                </div>
                <hr style="margin: 0">
                <div class="card-body bg-white">
                    <div class="row  p-3" style="border-bottom: 2px dashed lightblue">
                        <div class="col-6">
                            <div class="form-group mb-4">
                                <label for="command">{{ __('command') }}</label>
                                <select name="command" class="form-select" id="command">
                                    @foreach ($commands as $cmd)
                                        <option value="{{ $cmd->id }}">{{ $cmd->commands }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="command">{{ __('ip') }}</label>
                                <select name="ip" class="form-select" id="ip">
                                    @foreach ($ips as $key => $ip)
                                        <option value="{{ $ip }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" onclick="Commander.send()"
                                    id="sendBtn">{{ __('Send') }}</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="share mb-2">
                                <button onclick="Commander.clearConsole()" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                                <button onclick="Commander.copy()" class="btn bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                </button>
                                <button onclick="Commander.shareWhatsapp()" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                </button>
                                <button onclick="Commander.shareEmail()" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                </button>
                            </div>
                            <div class="ternimal" id="ternimal">
                                C:\
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('scripts')
    <script>
        var Commander = {

            terminal: $('#ternimal'),
            sendBtn: $('#sendBtn'),
            terminalUrl: "{{ route('branches.cmd') }}",
            whatsappLink: "https://wa.me/?text={text}",
            emailLink: "mailto:?subject={subject}&body={body}",
            processing: false,

            validate: function() {
                if (this.processing) {
                    alert('process already running');
                    return false;
                }
                if (!$('#ip').val() || !$('#command').val()) {
                    alert('choose ip and command');
                    return false;
                }
                return true;
            },

            disableOrEnableSending: function(disable = true) {
                if (disable) {
                    this.sendBtn.attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner" ></i>');
                } else {
                    this.sendBtn.removeAttr('disabled').html('Send');
                }
            },

            send: function() {
                if (!this.validate()) {
                    return false;
                }
                var data = {
                    ip: $('#ip').val(),
                    cmd_id: $('#command').val(),
                    _token: "{{ csrf_token() }}",
                };

                this.disableOrEnableSending(true);
                this.processing = true;
                var _this = this;
                $.post(this.terminalUrl, $.param(data), function(res) {
                    if (res.status) {
                        _this.console(res.data);
                    } else {
                        alert(res.msg);
                    }
                    _this.disableOrEnableSending(false);
                    _this.processing = false;
                });
            },

            console: function(msg) {
                var output = "<br>:> " + msg.replaceAll('\n', "<br>") + "<br>----------------------<br>";
                this.terminal.html(this.terminal.html() + output);
            },

            clearConsole: function() {
                this.terminal.html('C:\\');
            },

            shareWhatsapp() {
                var consoleText = this.terminal.text().replaceAll('\n', '\n\r');
                console.log(encodeURI(consoleText));
                var url = this.whatsappLink.replace("{text}", consoleText);
                window.open(encodeURI(url), "_blank");
            },

            shareEmail() {
                var consoleText = this.terminal.text();
                console.log(consoleText);
                consoleText = consoleText.replaceAll('<br>', '\n');
                var url = this.emailLink
                    .replace("{subject}", "Shell Commander:")
                    .replace("{body}", encodeURI(consoleText));
                window.open(url, "_blank");
            },

            copy: function() {
                var text = this.terminal.text();
                navigator.clipboard.writeText(text).then(function() {
                    console.log('Async: Copying to clipboard was successful!');
                }, function(err) {
                    console.error('Async: Could not copy text: ', err);
                });
            }

        };
    </script>
@endpush
