<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Chat Box</title>
        <style type="text/css">            
            .chatContainer {
                float: right;
                bottom: 0px;
                right: 5px;
                position: absolute;                
                display: inline-block;
            }
            .chatBox {                
                width: 20% ;
                min-width: 250px ;
                display: block;      
                border: 2px #668CFF solid;
                border-radius: 5px;
                clear: both;                
            }
            .chatHeader {
                width: 100%;
                padding: 0;
                margin: 0 auto;
                line-height: 1px;                
                clear: both;
                color: white;
                background-color: #668CFF;  
                display: inline-block;
                position: relative;
            }
            .chatHeader:hover {
                cursor: default;
            }
            .chatBody {
                width: 100%;
                min-height: 150px ;
                max-height: 200px ;                                
                overflow-y: scroll;                              
                clear: both;
                background-color: #EDF0FD;
                opacity: 1;
                position: relative;             
            }
            .chatFooter {
                width: 100%;
                position: relative;                
                clear: both;                    
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
                clear: left;
                background-color: #84a9f9;
                color: white;           
                opacity: 1;
                border-radius: 3px;
                position: relative;
                display: inline-block;
            }
            .chatMessageEndStyle {
                float: right;
                margin: 15px 5px 0px 0px;
                transform: rotate(60deg);                
                clear: right;
                position: relative;
                background-color: #84a9f9;
                border: 5px #84a9f9 solid;                
                display: inline-block;
            }
            .chatMessageSpanStyle {                                
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
                color: #668CFF;
                opacity: 0.9;
                background-color:#E1E6FC;
                border-radius: 10px;
                display: inline-block;                 
                position: relative;                
            }
            .chatCloseButton:hover {
                cursor: default;
            }
        </style>
        <script>
            var intervalVar;
            var count;
            function chatContainerObj() {
                return document.getElementById("chatContainer");
            }
            function chatBoxObj(object) {
                id=object.getAttribute('data-id');
                return document.getElementById("chatBox_"+id);
            }
            function chatHeaderObj(object) {
                id=object.getAttribute('data-id');
                return document.getElementById("chatHeader_"+id);
            }
            function chatBodyObj(object) {
                id=object.getAttribute('data-id');
                return document.getElementById("chatBody_"+id);               
            }
            function chatFooterObj(object) {
                id=object.getAttribute('data-id');
                return document.getElementById("chatFooter_"+id);
            }
            function chatMessageInputObj(object) {
                id=object.getAttribute('data-id');
                return document.getElementById("chatMessageInput_"+id);
            }

            function closeChatBox(object) {
                clearInterval(intervalVar);
                chatBoxObj(object).style.display="none";
            }
            function getPreviousMessages(object) {
                var request=new XMLHttpRequest();
                if(!request)
                    request=new ActiveXObject(Microsoft.XMLHTTP);
                request.open('POST','retrievemsg.php',false);                   
                request.responseType='JSON';         
                request.send(null);  
                chatBodyObj(object).innerHTML=request.responseText;
                if(count===0) {
                    chatBodyObj(object).scrollTop=chatBodyObj(object).scrollHeight;
                }
                count++;
                console.log(Date());
            }
            function displayChatBox(object) {
                count=0;
                getPreviousMessages(object);
                intervalVar=setInterval(function() { getPreviousMessages(object); },5000);
                console.log(intervalVar);
                chatBoxObj(object).style.display="block";
                chatHeaderObj(object).style.display="inline-block";               
                chatBodyObj(object).style.display="block";
                chatFooterObj(object).style.display="block";
                chatBodyObj(object).scrollTop=chatBodyObj(object).scrollHeight;
            }
            function performMessageAction(e,object) {
                var uniCode=e.keyCode ? e.keyCode : e.charCode;
                var message=chatMessageInputObj(object).value;                             
                if(uniCode===27) {
                    closeChatBox(object);
                } else if(uniCode===13) {                    
                    if((message !== "\n" && message !== "")) { 
                        message=message.replace(/(\n|\n|\r)/gm,"");
                        console.log(message);
                        chatBodyObj(object).innerHTML +="<div class='chatMessageEndStyle'></div><div class='chatMessage'><span class='chatMessageSpanStyle'>"+message+"</span></div>";
                        var request=new XMLHttpRequest();
                        if(!request)
                            request=new ActiveXObject(Microsoft.XMLHTTP);
                        request.open('POST','insertmsg.php',false);
                        request.setRequestHeader('username','pavan kumar');
                        request.setRequestHeader('message',message);                        
                        request.send(null);
                        console.log(request.responseText);
                    }
                    chatMessageInputObj(object).value="";
                    chatBodyObj(object).scrollTop=chatBodyObj(object).scrollHeight;                
                }             
            }
            function performHeaderAction(object) {
                if(chatBodyObj(object).style.display==="block") {
                    chatBodyObj(object).style.display="none";
                } else {
                    chatBodyObj(object).style.display="block";
                }
                if(chatFooterObj(object).style.display==="block") {
                    chatFooterObj(object).style.display="none";
                } else {
                    chatFooterObj(object).style.display="block";
                }
            }
        </script>
    </head>
    <body>
        <button data-id="54" onclick="javascript:displayChatBox(this);">Chat With PaOne</button>
        <button data-id="55" onclick="javascript:displayChatBox(this);">Chat With PaOne</button>
        <div id="chatContainer" class="chatContainer">
        <div id="chatBox_54" class="chatBox">
            <div id="chatHeader_54" class="chatHeader" data-id="54" onclick="javascript:performHeaderAction(this);">
                <h3 class="chatName">Pavan Kumar</h3>
                <div class="chatCloseButton" data-id="54" onclick="javascript:closeChatBox(this);"><h4>X</h4></div>
            </div>
            <div id="chatBody_54" class="chatBody">            
                
            </div>
            <div id="chatFooter_54" class="chatFooter">
                <textarea id="chatMessageInput_54" data-id="54" class="chatMessageInput" placeholder="Type Your Message Here" autofocus="true" onkeydown="javascript:performMessageAction(event,this);" ></textarea>
            </div>  
        </div>
            <div id="chatBox_55" class="chatBox">
            <div id="chatHeader_55" class="chatHeader" data-id="55" onclick="javascript:performHeaderAction(this);">
                <h3 class="chatName">Pavan Kumar</h3>
                <div class="chatCloseButton" data-id="55" onclick="javascript:closeChatBox(this);"><h4>X</h4></div>
            </div>
            <div id="chatBody_55" class="chatBody">            
                
            </div>
            <div id="chatFooter_55" class="chatFooter">
                <textarea id="chatMessageInput_55" data-id="55" class="chatMessageInput" placeholder="Type Your Message Here" autofocus="true" onkeydown="javascript:performMessageAction(event,this);" ></textarea>
            </div>  
        </div>

          <div id="chatBox_56" class="chatBox">
            <div id="chatHeader_56" class="chatHeader" data-id="56" onclick="javascript:performHeaderAction(this);">
                <h3 class="chatName">Pavan Kumar</h3>
                <div class="chatCloseButton" data-id="56" onclick="javascript:closeChatBox(this);"><h4>X</h4></div>
            </div>
            <div id="chatBody_56" class="chatBody">            
                
            </div>
            <div id="chatFooter_56" class="chatFooter">
                <textarea id="chatMessageInput_56" data-id="56" class="chatMessageInput" placeholder="Type Your Message Here" autofocus="true" onkeydown="javascript:performMessageAction(event,this);" ></textarea>
            </div>  
        </div>
        
        </div>
        <?php
        // put your code here                
        ?>
    </body>
</html>
