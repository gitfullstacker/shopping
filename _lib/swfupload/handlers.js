
/* This is an example of how to cancel all the files queued up.  It's made somewhat generic.  Just pass your SWFUpload
object in to this method and it loops through cancelling the uploads. */
function cancelQueue(instance) {
	//document.getElementById(instance.customSettings.cancelButtonId).disabled = true;
	instance.stopUpload();
	var stats;

	do {
		stats = instance.getStats();
		instance.cancelUpload();
	} while (stats.files_queued !== 0);

}

/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileDialogStart() {
	/* I don't need to do anything here */
}
function fileQueued(file) {
	try {
		// You might include code here that prevents the form from being submitted while the upload is in
		// progress.  Then you'll want to put code in the Queue Complete handler to "unblock" the form
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("업로드 Ready...");
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("대기열에 파일이 너무 많습니다\n" + (message === 0 ? "허용된 업로드 제한개수를 초과하였습니다." : message + " 개의 파일을 더 업로드 하실 수 있습니다."));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("제한용량 초과");
			this.debug("Error : 제한용량 초과, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("0byte 파일");
			this.debug("Error : 파일 크기가 0byte입니다, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("지원되지 않는 파일형식");
			this.debug("Error : 지원되지 않는 파일형식, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			alert("파일 개수가 초과되었습니다.  " +  (message > 1 ? message + " 개의 파일을 더 업로드하실 수 있습니다" : "더이상 업로드 하실 수 없습니다"));
			break;
		default:
			if (file !== null) {
				progress.setStatus("오류 발생");
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (this.getStats().files_queued > 0) {
			//document.getElementById(this.customSettings.cancelButtonId).disabled = false;
            //document.getElementById(this.customSettings.uploadButtonId).disabled = false;
		}

		/* I want auto start and I can do that here */
		this.startUpload();

	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and return true to indicate that the upload should start */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("업로드 중...");
		progress.toggleCancel(true, this);

        //document.getElementById(this.customSettings.uploadButtonId).disabled = true;
	}
	catch (ex) {
	}

	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {

	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("업로드 중...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("업로드 완료");
		progress.toggleCancel(false);

        var dir_type = this.customSettings.file_type;
        var up_dir   = this.customSettings.uploadDir + dir_type;
        if (dir_type=='image')
        {
            _mockdata[_mockdata.length] = {
                'imageurl': up_dir +'/'+ serverData,
				//'filename': serverData,
                'filename': file.name,
                'filesize': file.size,
                'imagealign': 'C',
                'originalurl': up_dir +'/'+ serverData,
                'thumburl': up_dir +'/'+ serverData
            };
        }
        else if (dir_type=='flash')
        {
            var flashData = serverData.split('|');
            _mockdata[_mockdata.length] = {
                'flashurl': up_dir +'/'+ flashData[0],
                'filename': serverData[0],
                'filesize': file.size,
                'flashalign': 'C',
                'width':flashData[1],
                'height':flashData[2]
            };
        }
        else if (dir_type=='attach')
        {
            // 폼에 히든 엘리먼트 추가 (form name 이 틀릴경우 파일을 추가할수 없음)
            var uploadedFile        = opener.document.createElement("frmWrite");
            uploadedFile.id         = "input_" + file.id;
            uploadedFile.name       = "uploadedFile[]";
            uploadedFile.className  = "uploadedfile";
            uploadedFile.type       = "hidden";
            uploadedFile.value      = serverData;   // 폼 변수값은 upload.php에서 리턴해주는 값을 저장한다. 실제저장되어 있는 임시 파일명

            opener.document.getElementById("frmWrite").appendChild(uploadedFile);  // 폼 변수값 추가
            //_mockdata[_mockdata.length] = eval('('+serverData+')');
            _mockdata[_mockdata.length] = {
                'attachurl': up_dir +'/'+ serverData,
                'filename': file.name,
                'filesize': file.size
            };
        }
		
		
        /*
        progress.fileProgressElement.childNodes[0].onclick=function(){
            // 취소버튼 클릭시 전송된 파일명을 저장하고 있는 히든 엘리먼트 삭제
            if (confirm("전송된 파일 \'" + file.name + "\'을 삭제하시겠습니까?")) {
                document.getElementById("form").removeChild(document.getElementById("input_" + file.id));
                progress.setTimer(setTimeout(function () {
                    progress.disappear();
                }, 300));
                swfu.setFileUploadLimit(swfu.getSetting("file_upload_limit")+1); // 파일전송 가능 개수를 1개 늘림
            }
        }
        */

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	try {
		/*  I want the next upload to continue automatically so I'll call startUpload here */
		if (this.getStats().files_queued === 0) {
			//document.getElementById(this.customSettings.cancelButtonId).disabled = true;

		} else {
			this.startUpload();
		}
	} catch (ex) {
		this.debug(ex);
	}

}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("Upload Error: " + message);
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
			progress.setStatus("Configuration Error");
			this.debug("Error Code: No backend file, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("Upload Failed.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("Server (IO) Error");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("Security Error");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("Upload limit exceeded.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SPECIFIED_FILE_ID_NOT_FOUND:
			progress.setStatus("File not found.");
			this.debug("Error Code: The file was not found, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("Failed Validation.  Upload skipped.");
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			if (this.getStats().files_queued === 0) {
				//document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus("Cancelled");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("Stopped");
			break;
		default:
			progress.setStatus("Unhandled Error: " + error_code);
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}