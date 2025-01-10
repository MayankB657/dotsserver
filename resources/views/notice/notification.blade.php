@php
    $url = 'https://node.sizaf.com';
@endphp
<div id="Notice"></div>
<input type="hidden" id="user_id" value="{{ Auth::id() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script src="{{ url('/') }}/public/js/moment.js"></script>
<script>
    $(document).ready(function() {
        window.addEventListener('click', (event) => {
            var modals = document.querySelectorAll('.previewmodal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    });
    var url = "{{ $url }}";
    const socket = io(url);
    var user_id = $('#user_id').val();
    socket.on('connect', () => {
        console.log('connected');
    });
    socket.on('receivedfor_' + user_id, (data) => {
        console.log(data);
        var NoticeDiv = $('#Notice');
        NoticeDiv.html('');
        if (data.title != '' && data.title != undefined) {
            var html = `<div id="preview-modal" role="dialog"
                            class="fixed inset-0 flex items-center z-10 justify-center bg-black bg-opacity-50 previewmodal">
                            <div class="w-full max-w-md rounded-2xl bg-white overflow-hidden modal-content" style="height: 400px;">
                                 <div class="flex justify-between py-4 border-b-2 items-center relative">
                                    <div class="flex mx-auto gap-2">
                                        <i class="ri-message-2-line"></i>
                                        <h2 class="text-base text-c-black font-bold">You've got a new message!</h2>
                                    </div>
                                    <i class="ri-close-circle-fill ri-lg cursor-pointer absolute right-3 top-3 dismissModel"></i>
                                </div>
                                 <div class="border-b-2">
                                    <div class="flex items-center justify-between py-3 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}" alt="profile" class="w-10">
                                            <span class="text-c-black font-medium">${data.title}</span>
                                        </div>
                                    </div>
                                    <div class="px-6 pb-2">
                                        <label for="message" class="text-c-black mb-1">Message:</label>
                                        <div id="message" class="h-48 text-sm overflow-y-scroll mini-scroll leading-normal pr-1">
                                           ${data.content}
                                        </div>
                                    </div>
                                </div>
                                 <div class="footer px-6 py-3">
                                    <span class="date text-c-black text-sm">${moment(data.schedule_time).format('YYYY-MM-DD')} at ${moment(data.schedule_time).format('H:mm:ss')}</span>
                                </div>
                            </div>
                        </div>`;
        } else {
            var html = `<div id="preview-modal" role="dialog"
                            class="fixed inset-0 flex items-center z-10 justify-center bg-black bg-opacity-50 previewmodal">
                            <div class="w-full max-w-md rounded-2xl bg-white overflow-hidden modal-content" style="height: 400px;">
                                 <div class="flex justify-between py-4 border-b-2 items-center relative">
                                    <div class="flex mx-auto gap-2">
                                        <i class="ri-message-2-line"></i>
                                        <h2 class="text-base text-c-black font-bold">You've got a new message!</h2>
                                    </div>
                                    <i class="ri-close-circle-fill ri-lg cursor-pointer absolute right-3 top-3 dismissModel"></i>
                                </div>
                                 <div class="border-b-2">
                                    <div class="flex items-center justify-between py-3 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}" alt="profile" class="w-10">
                                            <span class="text-c-black font-medium">${data.data.title}</span>
                                        </div>
                                    </div>
                                    <div class="px-6 pb-2">
                                        <label for="message" class="text-c-black mb-1">Message:</label>
                                        <div id="message" class="h-48 text-sm overflow-y-scroll mini-scroll leading-normal pr-1">
                                           ${data.data.content}
                                        </div>
                                    </div>
                                </div>
                                 <div class="footer px-6 py-3">
                                    <span class="date text-c-black text-sm">${moment(data.data.schedule_time).format('YYYY-MM-DD')} at ${moment(data.data.schedule_time).format('H:mm:ss')}</span>
                                </div>
                            </div>
                        </div>`;
        }
        NoticeDiv.html(html);
    });

    $(document).on('click', '.notification-item', function() {
        if (!$(event.target).hasClass('ReadThisNoti')) {
            var title = $(this).data('title');
            var content = $(this).data('content');
            var time = $(this).data('time');
            var id = $(this).data('id');
            var NoticeDiv = $('#Notice');
            NoticeDiv.html('');
            $('#NotiContainer').addClass('hidden');
            var html = `<div id="preview-modal" role="dialog"
                            class="fixed inset-0 flex items-center z-10 justify-center bg-black bg-opacity-50 previewmodal">
                            <div class="w-full max-w-md rounded-2xl bg-white overflow-hidden modal-content" style="height: 400px;">
                                 <div class="flex justify-between py-4 border-b-2 items-center relative">
                                    <div class="flex mx-auto gap-2">
                                        <i class="ri-message-2-line"></i>
                                        <h2 class="text-base text-c-black font-bold"> You've got a new message!</h2>
                                    </div>
                                    <i class="ri-close-circle-fill ri-lg cursor-pointer absolute right-3 top-3 dismissModel"></i>
                                </div>
                                 <div class="border-b-2">
                                    <div class="flex items-center justify-between py-3 px-6">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}" alt="profile" class="w-10">
                                            <span class="text-c-black font-medium">${title}</span>
                                        </div>
                                        <button class="text-c-yellow MarkasRead" data-id="${id}">Mark as read</button>
                                    </div>
                                    <div class="px-6 pb-2">
                                        <label for="message" class="text-c-black mb-1">Message:</label>
                                        <div id="message" class="h-48 text-sm overflow-y-scroll mini-scroll leading-normal pr-1">
                                           ${content}
                                        </div>
                                    </div>
                                </div>
                                 <div class="footer px-6 py-3">
                                    <span class="date text-c-black text-sm">${moment(time).format('YYYY-MM-DD')} at ${moment(time).format('H:mm:ss')}</span>
                                </div>
                            </div>
                        </div>`;
            NoticeDiv.html(html);
        }
    });
</script>
