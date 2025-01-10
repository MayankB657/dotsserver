
@if(!empty($iframeapp))
    @foreach($iframeapp as $iframekey=>$iframeval)
        @foreach($iframeval as $iframedetail)
        @if(!empty($iframedetail))
        <?php //print_r($iframedetail['filetype']);die;?>
               <!--Iframe popup-->

                <div id="iframepopup{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" data-app-id="iframepopup{{$iframedetail['filetype'].$iframedetail['filekey'] }}" class="draggableelement draggable-clock box popupiframe fixed inset-0 bg-black-900 bg-opacity-50 flex items-center justify-center rounded-lg hidden">
                        <div class="draggable bg-opacity-70  shadow-lg w-full h-full relative">
                        <div class="flex justify-between items-center p-1 pr-2 border-b bg-c-gray-gradient">
                            <span class="text-lg flex font-semibold">
                            <img class="w-5 h-5 mt-1" src="{{ checkIconExist($iframedetail['appicon'],'app') }}"/>
                            <h2 class="text-white ml-2 font-thin">
                                {{$iframedetail['appname'] }}
                            </h2>
                            </span>
                            <div class="flex space-x-1">
                            <a href="#"  class="minimizeiframe-btn" data-iframe-id="{{$iframedetail['filetype'].$iframedetail['filekey'] }}"><img src="{{ asset($constants['IMAGEFILEPATH'].'minimize'.$constants['ICONEXTENSION'])}}"/></a>
                            <a href="#" class="maximizeiframe-btn" data-iframe-id="{{$iframedetail['filetype'].$iframedetail['filekey'] }}"><img src="{{ asset($constants['IMAGEFILEPATH'].'maximize'.$constants['ICONEXTENSION'])}}"/></a>
                            <a href="#" class="closeiframe-btn" data-filekey="{{$iframedetail['filekey'] }}" data-iframe-id = "{{$iframedetail['filetype'].$iframedetail['filekey'] }}" data-appkey="{{ $iframedetail['appkey'] }}" data-filetype="{{ $iframedetail['filetype'] }}" ><img src="{{ asset($constants['IMAGEFILEPATH'].'close'.$constants['ICONEXTENSION'])}}"/></a>
                            <input type="hidden" name="filekey" id="filekey" value="{{$iframedetail['filekey'] }}" />   
                        </div>
                        </div>
                    
                        @if ($iframedetail['extension'] == 'editor')
                        <!--comment section-->

                         <div class="commentssection absolute bottom-0 top-9 flex h-11/12 flex-col border-r bg-c-lighten-gray hidden md:w-1/3  font-size-14">
          <div class="resizer absolute top-0 right-0 w-1 h-full" style="cursor: ew-resize; background-color: #d1d5db"></div>
          <div class="sticky top-0 z-10 flex items-center justify-between border-b px-4 py-2">
            <h3 class="font-medium font-size-16">Comments</h3>
            <div>
              <button class="pr-2 comment-button" onclick="togglePane('.addcomment')" data-type="comment">
                <i class="ri-chat-new-line ri-lg"></i>
            </button>
            <button onclick="togglePane('.commentssection')">
                <i class="ri-close-fill ri-lg"></i>
            </button>
        </div>
    </div>

       
                            <!--chat list-->
                            <div class="flex-1 overflow-auto comment-list">
                                <div class="space-y-4 p-4" id="message_view">
                                <!-- @if(isset($messages) && $messages->isNotEmpty()) -->

                                    <!-- @else
                                        <p>No comments found.</p>
                                        @endif -->
                                    </div>
                                </div>
                                <!--Add comment-->
                                <div class="addcomment sticky bottom-0 z-10 border-t px-4 py-2 hidden bg-c-lighten-gray relative">
                                    <!-- Mention list -->
                                    <div class="absolute mentionList hidden bg-c-white border border-c-medium-gray rounded-md shadow-lg z-20 max-h-40 overflow-y-auto bottom-full">
                                    <!-- Mention items will be dynamically inserted here -->
                                </div>
                                <div class="flex items-center gap-2 relative">
                                    <div class="flex-1 relative">
                                        <textarea placeholder="Write a new comment..." class="commentTextarea w-full rounded-md border border-c-medium-gray p-2 text-sm focus:outline-none bg-transparent relative z-10 text-transparent caret-black" rows="4" style="caret-color: black"></textarea>
                                        <div class="styledTextarea absolute top-0 left-0 w-full h-full p-2 text-sm pointer-events-none whitespace-pre-wrap break-words overflow-hidden bg-transparent"></div>
                                    </div>
                                    <button data-fileid=" {{ $iframedetail['filekey'] }}" class="postButton border px-3 hover-bg-c-black hover-text-c-yellow text-sm py-1 rounded border-gray-600 bg-c-yellow">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </div>
                            <!--comment section-->
                        @endif

                        <!--Iframe-->
                        <iframe id="iframe{{ $iframedetail['filetype'].$iframedetail['filekey'] }}" src="{{ $iframedetail['iframeurl'] }}" class="w-full h-full frame"></iframe>
                        <!--chat button-->
                        @if ($iframedetail['extension'] == 'editor')
                            <div class="absolute bottom-5 left-5 bg-gray-300 rounded-full px-2 py-1 commentbutton">
                            <button class="comment" data-filekey="{{ $iframedetail['filetype'] . $iframedetail['filekey'] }}" onclick="togglePane('.commentssection')">
                                <i class="ri-chat-4-line ri-lg"></i>
                            </button>
                            </div>
                        @endif  
                          <!--chat button-->
        
                        
                        </div>
                    </div>
                <!-- iframe close -->
                 @endif
        @endforeach
     @endforeach
@endif

<script>

    
var baseUrl = "{{url('/')}}";


(function () {
 const commentSection = document.querySelector(".commentssection");
 const commentButton = document.querySelector(".commentbutton");
 const resizer = document.querySelector(".resizer");
 const commentList = document.querySelector(".comment-list");
 const mentionList = document.querySelector(".mentionList");
 const textarea = document.querySelector(".commentTextarea");
 const styledTextarea = document.querySelector(".styledTextarea");
 const iframePopup = document.querySelector(".popupiframe iframe");
 const postButton = document.querySelector(".postButton");
 const addComment = document.querySelector(".addcomment");
 if (commentSection && commentButton && resizer && commentList && mentionList && textarea && styledTextarea && iframePopup && postButton && addComment) {

 let selectedMention = null;
let selectedMentionArr = [];
  let hasEventListenerBeenAdded = false; // Track if the event listener has been added
  let parentMessageId = null; // Store the parent message ID

  function togglePane(id) {
    let element = document.querySelector(id);
    if (element) {
      element.classList.toggle("hidden");
      if (!element.classList.contains("hidden")) {
        scrollToBottom();
    }
    updateFrameMargin();
    } else {
   /* console.error(`Element with selector ${id} not found.`);*/
    }
}

window.togglePane = togglePane;

function scrollToBottom() {
    if (commentList) {
      commentList.scrollTop = commentList.scrollHeight;
  }
}

function updateFrameMargin() {
    if (window.innerWidth > 768 && commentSection) {
      if (commentSection.classList.contains("hidden")) {
        iframePopup.style.width = "100%";
        iframePopup.style.marginLeft = "0";
        commentButton.style.marginLeft = "0";
    } else {
        const commentsWidth = commentSection.offsetWidth;
        iframePopup.style.width = `calc(100% - ${commentsWidth}px)`;
        commentButton.style.marginLeft = `${commentSection.offsetWidth}px`;
        iframePopup.style.marginLeft = `${commentSection.offsetWidth}px`;
    }
}
}

let startX, startWidth;

const initResize = (e) => {
    e.preventDefault();
    startX = e.clientX;
    startWidth = commentSection.offsetWidth;

    window.addEventListener("mousemove", startResizing);
    window.addEventListener("mouseup", stopResizing);
};

const startResizing = (e) => {
    const minWidth = 250;
    const maxWidth = 500;
    let newWidth = startWidth + (e.clientX - startX);

    if (newWidth < minWidth) newWidth = minWidth;
    else if (newWidth > maxWidth) newWidth = maxWidth;

    if (commentSection) {
      commentSection.style.width = `${newWidth}px`;
      updateFrameMargin();
  }
};

const stopResizing = () => {
    window.removeEventListener("mousemove", startResizing);
    window.removeEventListener("mouseup", stopResizing);
};

if (resizer) {
    resizer.addEventListener("mousedown", initResize);
}

updateFrameMargin();

let users = [];
let groups = [];
let roles = [];
let messages = [];

function fetchUsers() {
  
    var url = "{{ route('getUsers') }}";
     
    fetch(url)
    .then((response) => response.json())
    .then((data) => {
        users = data.users;
        groups = data.groups;
        roles = data.roles;
    })
    .catch((error) => console.error("Error fetching users:", error));
}
fetchUsers();


function fetchMessages() {
    const fileID = $('#filekey').val();
    // var url = "{{ route('getMessageData') }}";
    const url = "{{ route('getMessageData') }}?fileID=" + encodeURIComponent(fileID);

    
    fetch(url)
    .then((response) => response.json())
    .then((data) => {

        messages = data.messages;
        /*console.log(messages)*/
        // Clear existing messages
        $('#message_view').empty();

        // Append each message to the message_view div
        $.each(messages, function(index, comment) {
          // console.log('===================');
          var rec = '';

          /*if(comment.receiver_type == "Group"){
            console.log('ggggg', comment.receiver_type, comment.group)
            rec = comment.group != null ? '@'+comment.group.name : '';
          } else if(comment.receiver_type == "Role"){
            console.log('rrrrr', comment.receiver_type, comment.role)
            rec = comment.role != null ? '@'+comment.role.name : '';
          } else {
            rec = comment.comment_recivers.length > 0 ? comment.comment_recivers.map(r => `@${r.receiver.name}`).join(', ') : '' ;
        }*/

        const processedMessage = processMessage(comment.message);
          // console.log(rec);
          let messageHtml = `
          <div class="grid gap-2 border-b">
          <div class="flex items-start gap-3">
          <div class="h-8 w-8 rounded-full">
          <img src="images/avatar.png" alt="Avatar" class="h-8 w-8 rounded-full" />
          </div>
          <div class="flex-1 space-y-1">
          <div class="flex items-center justify-between">
          <div class="font-medium text-base">${comment.user.name}</div>
          <div class="text-xs">${new Date(comment.created_at).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
          </div>
          <p> <span style="color:blue; font-style: italic;">${rec}</span> ${processedMessage}</p>
          <div class="flex items-center gap-2">
          <button onclick="togglePane('.addcomment')" class="p-2 reply-button" data-type="reply" data-message-id="${comment.id}">
          <i class="ri-reply-line"></i>
          </button>
          <button id="comments-iframe" class="p-2 delete-button" data-message-id="${comment.id}">
          <i class="ri-delete-bin-line"></i>
          </button>

          </div>
          </div>
          </div>
          </div>
          `;
          $('#message_view').append(messageHtml);
      });

    })
    .catch((error) => console.error("Error fetching messages:", error));
}
fetchMessages();

function processMessage(message) {
      
      const mentionRegex = /@(\w+)/g;

    return message.replace(mentionRegex, '<span style="color:blue; font-style: italic;">@$1</span>');
}

function highlightMentions(text) {
    const regex = /(@[a-zA-Z]+)/g;
    return text.replace(regex, (match) => `<span class="text-link-blue">${match}</span>`);
}

textarea.addEventListener("input", (e) => {
    handleInput(e, textarea, styledTextarea);
});

function handleInput(e, textareaElement, styledTextareaElement) {
    const value = e.target.value;
    const cursorPosition = e.target.selectionStart;
    const lastAtIndex = value.lastIndexOf("@", cursorPosition - 1);

    if (styledTextareaElement) {
      styledTextareaElement.innerHTML =
      highlightMentions(value) +
      "<br>".repeat(textareaElement.rows - (textareaElement.value.match(/\n/g) || []).length);
  }

  if (lastAtIndex !== -1) {
      const query = value.slice(lastAtIndex + 1, cursorPosition);
      const filteredUsers = users.filter((user) =>
        user.name.toLowerCase().includes(query.toLowerCase())
        );
      const filteredGroups = groups.filter((group) =>
        group.name.toLowerCase().includes(query.toLowerCase())
        );
      const filteredRoles = roles.filter((role) =>
        role.name.toLowerCase().includes(query.toLowerCase())
        );
      const filteredResults = [
      ...filteredUsers.map((user) => ({
          type: "User",
          id: user.id,
          name: user.name,
      })),
      ...filteredGroups.map((group) => ({
          type: "Group",
          id: group.id,
          name: group.name,
      })),
      ...filteredRoles.map((role) => ({
          type: "Role",
          id: role.id,
          name: role.name,
      })),
      ];

      if (filteredResults.length > 0) {
        mentionList.innerHTML = filteredResults
        .map(
            (result) =>
            `<div class="px-4 py-2 hover-bg-c-yellow text-c-black cursor-pointer" data-type="${result.type}" data-id="${result.id}" data-name="${result.name}">
            ${result.name} (${result.type})
            </div>`
            )
        .join("");
        mentionList.style.width = `${textareaElement.offsetWidth}px`;
        mentionList.classList.remove("hidden");
    } else {
        mentionList.classList.add("hidden");
    }
} else {
  mentionList.classList.add("hidden");
}
}

mentionList.addEventListener("click", (e) => {
    if (e.target.dataset.name) {
      insertMention(e, textarea);
  }
});

function insertMention(e, textareaElement) {
    /*console.log("Inserting mention:", e.target.dataset);*/

    const cursorPosition = textareaElement.selectionStart;
    const value = textareaElement.value;
    const lastAtIndex = value.lastIndexOf("@", cursorPosition - 1);

    const newValue =
    value.slice(0, lastAtIndex + 1) + e.target.dataset.name + " " + value.slice(cursorPosition);
    textareaElement.value = newValue;
    textareaElement.focus();
    textareaElement.setSelectionRange(
      lastAtIndex + 1 + e.target.dataset.name.length + 1,
      lastAtIndex + 1 + e.target.dataset.name.length + 1
      );

    styledTextarea.innerHTML =
    highlightMentions(textareaElement.value) +
    "<br>".repeat(textareaElement.rows - (textareaElement.value.match(/\n/g) || []).length);

    selectedMention = {
      id: e.target.dataset.id,
      type: e.target.dataset.type,
  };

  selectedMentionArr.push(selectedMention)

    // console.log('>>>>>>> ', selectedMention, selectedMentionArr)

    mentionList.classList.add("hidden");
}

function addPostButtonClickListener() {
    if (hasEventListenerBeenAdded) return;
    hasEventListenerBeenAdded = true;

    document.addEventListener("click", handlePostButtonClick);
}

function handlePostButtonClick(event) {
    const button = event.target.closest(".postButton");
    // let fileId = button.getAttribute("data-fileid");

    if (!button) return;

    const authUserId = {{ auth()->user()->id }};
    console.log(authUserId);
    console.log("--------------------");
    //const fileID = "MQ";
    const fileID = $('#filekey').val();

    if (textarea) {
      // const message = textarea.value.replace(/@\w+\s/g, "").trim();
      const message = textarea.value;

     /* console.log("Button type:", button.classList.contains("reply-button") ? "reply" : "comment");
      console.log("Parent message ID:", parentMessageId);
      console.log("Selected mention:", selectedMention);
      */
      if (message) {
        const parsedFileID = fileID
        const bodyData = {
          user_id: authUserId,
          receiver_id: selectedMention ? selectedMention.id : null,
          receiver_type: selectedMention ? selectedMention.type : null,
          message: message,
          fileID: parsedFileID,
          parent_message_id: parentMessageId,
          user_array: selectedMentionArr,
      };

      /*        console.log("Request body:", bodyData);*/
//route('saveComnet')
var url = "{{ route('saveComment') }}";
      fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify(bodyData),
    })
      .then((response) => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        fetchMessages();
        return response.text();
    })
      .then((text) => {
          try {
            const data = JSON.parse(text);
            /*console.log("Saved comment or reply:", data);*/
            if (data.success) {
              textarea.value = "";
              styledTextarea.innerHTML = "";
              selectedMention = null;
              selectedMentionArr = [];
              mentionList.classList.add("hidden");
              textarea.dataset.parentMessageId = ""; // Clear parentMessageId after saving
              if (addComment) {
                addComment.classList.add("hidden");
            }
        } else {
           /* console.error("Error from server:", data.message);*/
       }
   } catch (e) {
    /*console.error("Failed to parse JSON:", e);*/
    /* console.error("Response text:", text);*/
}
})
      .catch((error) => console.error("Error saving comment or reply:", error));
  } else {
    /*console.log("Message is empty.");*/
}
} else {
   /* console.error("Textarea element not found.");*/
}
}

function handleReplyButtonClick(event) {
    const replyButton = event.target.closest(".reply-button");
    if (!replyButton) return; // Ensure the click is on a replyButton

    parentMessageId = replyButton.getAttribute("data-message-id");

    // Show the textarea and store the parent message ID
    if (addComment) {
      addComment.classList.remove("hidden");
      textarea.dataset.parentMessageId = parentMessageId;
  }

  /*console.log("Reply button clicked. Parent message ID:", parentMessageId);*/
}

if (!hasEventListenerBeenAdded) {
    addPostButtonClickListener();
}

document.addEventListener("click", handleReplyButtonClick);

$(document).off('click', '.delete-button').on('click', '.delete-button', function() {
    var messageId = $(this).data('message-id');

    $.ajax({
        url: 'delete-message', // Update this URL to your actual route
        type: 'DELETE',
        data: {
            id: messageId,
            _token: '{{ csrf_token() }}' // CSRF token for security (if using Laravel or similar frameworks)
        },
        success: function(response) {
            if (response.success) {
                alert('Message deleted successfully');
                // Refresh the iframe content
                fetchMessages(); // or any other function to reload the messages
            } else {
                // Handle failure response
            }
        },
        error: function(xhr) {
            // Handle error response
        }
    });
});
 }
})();



</script>