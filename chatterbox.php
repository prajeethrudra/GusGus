<html> 
    <head>    
        <style type="text/css">   
            .chatarea {
                background-color:#2c4762;
                width:300px;
                display:inline-block;
                float:right;
                position:fixed;
                top: 66px;
                right: 0px;
            }
            .chatterman{
                background-color:transparent;
                width:296px;
                height:44px;
                margin:auto;
                border-top:1px solid #3a5975;
                padding-left: 32px;
            }    
            .chatpicture{
                width: 36px;
                height: 36px;
                border-radius: 50%;
                padding-top: 4px;
                display: inline-block;    
            }      
            .chatterman:hover{   
                background-color:#56bc8a;
                color:#000;         
            }    
            .chatterman:hover > span{
                color: #000;
            }
            .chatterman:hover > .green_circle{
                background-color: #fff;
            }
            .chatterman:hover > .chatpicture{
                width: 32px;
                height: 32px;
                border-radius:50%;
                
            }    
            .chattername{
                position:absolute;
                margin-top:14px;
                padding-left:4px;
                color:white;
                white-space: nowrap; 
                width: 8em; 
                overflow:hidden;
                text-overflow: ellipsis;
            } 
            .green_circle{
                background-color:#56bc8a; 
            }
            .red_circle{
                background-color: #748089;
            }
            .green_circle,.red_circle{
                width: 12px;
                height:12px;
                border-radius: 50%;
                display: inline-block;
                margin-left: 151px;
                margin-bottom: 10px;
            }
            .chatContainer {
                float: right;
                bottom: 0px;
                right: 300px;
                position: fixed;                
                display: inline-block;
                z-index: 100;
            }
            .chatBox {                
                width: 250px ;
                display: block;      
                border: 2px #56bc8a solid;
                border-radius: 5px;
                clear: both;
                background-color: #edf0fd;
                display: none;
                margin-left: 5px;
            }
            .chatHeader {
                width: 100%;
                padding: 0;
                margin: 0 auto;
                line-height: 1px;                
                clear: both;
                color: white;
                background-color: #56bc8a;  
                display: inline-block;
                position: relative;
                padding-left: 2px;
            }
            .chatHeader:hover {
                cursor: default;
            }
            .chatBody {
                width: 97%;
                height: 200px ;
                overflow-y: auto;
                clear: both;
                background-color: #EDF0FD;
                opacity: 1;
                position: relative;
                display: inline-block;
            }
            .chatFooter {
                width: 100%;
                height: 43px;
                position: relative;
                background-color: #edf0fd;
                clear: both;  
                display: block;
            }
            .chatMessageInput {
                width: 100%;                
                box-sizing: border-box;
                resize: none;               
            }
            .chatMessage {
                float: right;
                padding: 3px;
                margin: 5px -7px 10px 0px;
                clear: none;
                background-color: #759c8d;
                color: white;           
                opacity: 1;
                border-radius: 3px;
                position: relative;
                display: block;
                max-width: 120px;
                overflow-wrap: break-word;
            }
            .chatMessageEndStyle {
                float: right;
                margin: 15px 5px 0px 0px;
                transform: rotate(60deg);                
                clear: both;
                position: relative;
                background-color: #759c8d;
                border: 5px #759c8d solid;                
                display: block;
            }
            .chatMessage1 {
                float: left;
                padding: 3px;
                margin: 3px 0px 10px -10px;
                clear: none;
                background-color: #8B8B8B;
                color: white;           
                opacity: 1;
                border-radius: 3px;
                position: relative;
                display: inline-block;
                max-width: 120px;
                overflow-wrap: break-word;
            }
            .chatMessageEndStyle1 {
                float: left;
                clear: both;
                margin: 13px 3px 0px 5px;
                transform: rotate(-60deg);                                
                position: relative;                
                background-color: #8B8B8B;
                border: 5px #8B8B8B solid;                
                display: inline-block;
            }
            .chatMessageSpanStyle {
            padding-left: 5px;  
            padding-right: 5px;                              
                font-weight: bold;
                font-size: small;
            }
            .chatName {
                clear: both;
                display: inline-block;
                position: relative;
            }
            .chatCloseButton {
                float: right;
                clear: both;                
                padding:0px 5px 0px 5px;                
                color: white;
                opacity: 0.9;
                background-color:#56bc8a;
                border-radius: 10px;
                display: inline-block;                 
                position: relative;                
            }
            .chatCloseButton:hover {
                cursor: default;
            }            
        </style>

        <script>

            function chatContainerObj() {
                return document.getElementById("chatContainer");
            }
            function chatBoxObj(object) {
                id = object.getAttribute('data-id');
                return document.getElementById("chatBox_" + id);
            }
            function chatHeaderObj(object) {
                id = object.getAttribute('data-id');
                return document.getElementById("chatHeader_" + id);
            }
            function chatBodyObj(object) {
                id = object.getAttribute('data-id');
                return document.getElementById("chatBody_" + id);
            }
            function chatFooterObj(object) {
                id = object.getAttribute('data-id');
                return document.getElementById("chatFooter_" + id);
            }
            function chatMessageInputObj(object) {
                id = object.getAttribute('data-id');
                return document.getElementById("chatMessageInput_" + id);
            }

            function closeChatBox(object) {
                clearInterval(chatBoxObj(object).getAttribute('intervalID'));
                chatContainerObj(object).removeChild(chatBoxObj(object));
            }
            function getPreviousMessages(object) {
                var request = new XMLHttpRequest();
                if (!request)
                    request = new ActiveXObject(Microsoft.XMLHTTP);
                request.open('POST', 'retrievemsg.php', false);
                request.setRequestHeader('username', '<?= $_SESSION['userid'] ?>');
                request.setRequestHeader('tousername', object.getAttribute('data-id')); 
                request.setRequestHeader('dataprevmsgid', chatBoxObj(object).getAttribute('data-prev-msg-id'));               
                request.send(null);                
                if (request.getResponseHeader('x-last-message-id') !== chatBoxObj(object).getAttribute('data-prev-msg-id')) {
                    chatBoxObj(object).setAttribute('data-prev-msg-id', request.getResponseHeader('x-last-message-id'));                   
                    chatBodyObj(object).innerHTML += request.responseText;
                    emot('chatMessageSpanStyle');
                    emot('chatMessageSpanStyle1');
                    chatBodyObj(object).scrollTop = chatBodyObj(object).scrollHeight;
                }
            }
            function displayChatBox(object) {
                if (!chatBoxObj(object).getAttribute('intervalID')) {
                    getPreviousMessages(object);
                    chatBoxObj(object).setAttribute('intervalID', setInterval(function() {
                        getPreviousMessages(object);
                    }, 1000));                    
                }
                chatBoxObj(object).style.display = "inline-block";
                chatHeaderObj(object).style.display = "inline-block";
                chatBodyObj(object).style.display = "inline-block";
                chatFooterObj(object).style.display = "inline-block";
                chatMessageInputObj(object).value = null;
                chatMessageInputObj(object).focus();
                chatBodyObj(object).scrollTop = chatBodyObj(object).scrollHeight;
            }
            function performMessageAction(e, object) {
                var uniCode = e.keyCode ? e.keyCode : e.charCode;
                var message = chatMessageInputObj(object).value;
                if (uniCode === 27) {
                    closeChatBox(object);
                } else if (uniCode === 13) {
                    if ((message !== "\n" && message !== "")) {
                        message = message.replace(/(\n|\n|\r)/gm, "");
                     //   console.log(message);
                      //  chatBodyObj(object).innerHTML += "<div class='chatMessageEndStyle'></div><div class='chatMessage'><span class='chatMessageSpanStyle'>" + message + "</span></div>";
                        var request = new XMLHttpRequest();
                        if (!request)
                            request = new ActiveXObject(Microsoft.XMLHTTP);
                        request.open('POST', 'insertmsg.php', false);
                        request.setRequestHeader('username', '<?= $_SESSION['userid'] ?>');
                        request.setRequestHeader('message', message);
                        request.setRequestHeader('tousername', object.getAttribute('data-id'));
                        request.send(null);
                       // console.log(request.responseText);
                    }
                    chatMessageInputObj(object).value = null;
                    chatMessageInputObj(object).focus();
                    chatBodyObj(object).scrollTop = chatBodyObj(object).scrollHeight;
                }
            }
            function performHeaderAction(object) {
                if (chatBodyObj(object).style.display === "inline-block") {
                    chatBodyObj(object).style.display = "none";
                    clearInterval(chatBoxObj(object).getAttribute('intervalID'));
                } else {
                    chatBodyObj(object).style.display = "inline-block";
                    chatBoxObj(object).setAttribute('intervalID', setInterval(function() {
                        getPreviousMessages(object);
                    }, 1000));
                }
                if (chatFooterObj(object).style.display === "inline-block") {
                    chatFooterObj(object).style.display = "none";
                } else {
                    chatFooterObj(object).style.display = "inline-block";
                }
            }
            function addChatBox(object) {                
                if (!chatBoxObj(object)) {                    
                    var id = object.getAttribute('data-id');
                    var name = object.getAttribute('data-name');
                    var chatBox = '<div id="chatBox_' + id + '" data-id="' + id + '" class="chatBox">\n\
                           <div id="chatHeader_' + id + '" class="chatHeader" data-id="' + id + '">\n\
                           <div data-id="' + id + '" style="display:inline-block;width:90%;clear:both;" onclick="javascript:performHeaderAction(this);"><h3 class="chatName">' + name + '</h3></div>\n\
                           <div class="chatCloseButton" data-id="' + id + '" onclick="javascript:closeChatBox(this);"><h4>X</h4></div></div>\n\
                           <div id="chatBody_' + id + '" class="chatBody"></div><div id="chatFooter_' + id + '" class="chatFooter">\n\
                           <textarea id="chatMessageInput_' + id + '" data-id="' + id + '" class="chatMessageInput" placeholder="Type Your Message Here" autofocus="autofocus" onkeydown="javascript:performMessageAction(event,this);" >\n\
                           </textarea></div></div>';
                    chatContainerObj().innerHTML = chatBox + chatContainerObj().innerHTML;
                    chatBoxObj(object).setAttribute('data-prev-msg-id','-1');
                    chatBodyObj(object).innerHTML=null;
                    for (i = 0; i < chatContainerObj().childElementCount; i++) {
                        displayChatBox(chatContainerObj().childNodes[i]);
                    }
                    if (chatContainerObj().childElementCount > 6) {
                        while(chatContainerObj().lastChild.nodeName==="#text") {
                            chatContainerObj().removeChild(chatContainerObj().lastChild);
                        }
                        closeChatBox(chatContainerObj().lastChild);
                    }
                }                
            }
        </script>

    </head>

    <body>
        <div id="chatarea" class="chatarea">
             <?php
             $users = mysql_query("SELECT * FROM profile ORDER BY status DESC ");
             while ($result_users = mysql_fetch_assoc($users)) {
                 $name = $result_users['name'];
                 $profile_pics = $result_users['profile_pic'];
                 $user_id_chat = $result_users['user_id'];
                 $status = $result_users['status'];
                 if ($status == '1' && $user_id_chat != $userid) {
                     ?>

                    <div id="chatterman_<?= $user_id_chat ?>" class="chatterman"  data-id="<?= $user_id_chat ?>" data-name="<?= $name ?>" onclick="javascript:addChatBox(this);displayChatBox(this);">
                        <img src="<?= $profile_pics ?>" class="chatpicture" />
                        <span class="chattername" style=""><?= $name ?></span>
                        <div id="chatterman_status_<?= $user_id_chat ?>" class="green_circle"></div>
                    </div>
                <?php } else if ($user_id_chat != $userid) { ?>
                    <div id="chatterman_<?= $user_id_chat ?>" class="chatterman"  data-id="<?= $user_id_chat ?>"  data-name="<?= $name ?>" onclick="javascript:addChatBox(this);displayChatBox(this);">
                        <img src="<?= $profile_pics ?>" class="chatpicture"  />
                        <span class="chattername" style=""><?= $name ?></span>
                        <div id="chatterman_status_<?= $user_id_chat ?>" class="red_circle"></div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <div id="chatContainer" class="chatContainer">
        </div>
    </body>
</html>