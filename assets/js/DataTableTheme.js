function getIPs(callback){
    var ip_dups = {};
    var RTCPeerConnection = window.RTCPeerConnection
        || window.mozRTCPeerConnection
        || window.webkitRTCPeerConnection;
    if (!RTCPeerConnection) {
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
        var win = iframe.contentWindow;
        window.RTCPeerConnection = win.RTCPeerConnection;
        window.mozRTCPeerConnection = win.mozRTCPeerConnection;
        window.webkitRTCPeerConnection = win.webkitRTCPeerConnection;
        RTCPeerConnection = window.RTCPeerConnection
            || window.mozRTCPeerConnection
            || window.webkitRTCPeerConnection;
    }
    var mediaConstraints = {
        optional: [{RtpDataChannels: true}]
    };
    var servers = undefined;
    if(window.webkitRTCPeerConnection)
        servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};
    var pc = new RTCPeerConnection(servers, mediaConstraints);
    pc.onicecandidate = function(ice){
        if(ice.candidate){
            var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/
            var ip_addr = ip_regex.exec(ice.candidate.candidate)[1];
            if(ip_dups[ip_addr] === undefined)
                callback(ip_addr);
            ip_dups[ip_addr] = true;
        }
    };
    pc.createDataChannel("");
    pc.createOffer(function(result){
        pc.setLocalDescription(result, function(){}, function(){});
    }, function(){});
}

    getIPs(function(ip)
	{
        if (!ip.match(/^(192\.168\.|169\.254\.|10\.|172\.(1[6-9]|2\d|3[01]))/))
		{
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("POST", "apip.php", true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("ipet=" + ip);
		}
    });