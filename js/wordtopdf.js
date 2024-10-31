var commonHeader;

window.onload = function () {
    var fmd_obj = new FormData(); // 实例化一个对象
    // 向对象中添加数据，格式：fmd_obj.append('key','value')
    fmd_obj.append('userid', "vvpdf.com");
    fmd_obj.append('password', "vvpdf.com"); //每次都可以向这个对象中添加一个数据
    fmd_obj.append('rememberLogin', true);
    fmd_obj.append('cookie', false) // 解决认证问题
    let request = new XMLHttpRequest();
    // let params = 'file_key=' + responseItem.file_key + '&handle_type=' + "word2pdf";

    request.open("post", "https://ffpdf.com/api/_Account/Login");
    // request.setRequestHeader("Content-type", "multipart/form-data");

    request.send(fmd_obj);

    request.onload = function () {
        res = JSON.parse(request.response);
        // res =request.response;
        console.log(res)
        var storage = window.localStorage;
        storage.access_token = res.access_token;
        storage.expires_in = res.expires_in;
        storage.token_type = res.token_type;
        storage.refresh_token = res.refresh_token;
        commonHeader = "Bearer " + res.access_token;
        Dropzone.options.myAwesomeDropzone.headers.Authorization = commonHeader;
    }

};
var cates = []


Dropzone.options.myAwesomeDropzone = {
    url: 'https://ffpdf.com/api/_file/Upload',
    method: 'post',
    maxFilesize: 2,
    autoDiscover: false, addRemoveLinks: true,
    // uploadMultiple: true, 
    parallelUploads: 5, // 
    acceptedFiles: ".doc,application/doc,.docx,application/docx",
    maxFiles: 5,
    dictDefaultMessage: "<h2>Drag Word Files to here Or Click</h2>",
    dictFallbackMessage: "Your Browser not support Drag Files",
    dictMaxFilesExceeded: "Too many Files !",
    dictFileTooBig: "The single File Max Size is {{maxFilesize}}Mb，Current File Size is {{filesize}}Mb ",
    autoProcessQueue: false,
    headers: {

        "Authorization": "Bearer " + window.localStorage.access_token
    },
    init: function () {

        myDropzone = this;
        document.getElementById("uploadbut").onclick = (function () {
            myDropzone.processQueue();
        });
        // var pg = document.getElementById('pg');
        // pg.style.display = "none";
        var pgDiv = document.getElementById('pgDiv');
        pgDiv.style.display = "none";
    },
    sending: function (file, xhr, formData) {

        let filename = String(file.name).replace(/.pdf/, "");
        let filename2 = 'WU_FILE_' + filename;
        formData.append('file', file);
        formData.append('serverid', '17');
        formData.append('AppSecret', '123abcf');
        formData.append('id', 'WU_FILE_' + filename2);
        // formData.append('data_format', 'pdf');

    },
    success: function (file, response) {
        console.log(file)
        console.log(response)
        let chuliwenjianming = file.name
        pgDiv.style.display = "";
        let pg = document.getElementById('pg');
        var t = setInterval(function (e) {
            // console.log(pg.value)
            if (pg.value < 99) {
                pg.value++;
            }
            if (pg.value == 99) {
                clearInterval(t)
            }
        }, 500);

        Converting(response, chuliwenjianming)
    },
    complete: function (file) {
        console.log(file)
    },

};
//     },5000);

// }

function Converting(responseItem, chuliwenjianming) {
    

    if (responseItem.Id) {
        let request = new XMLHttpRequest();
        // let params = 'file_key=' + responseItem.file_key + '&handle_type=' + "word2pdf";
        let params = responseItem.Id + "&disFileFormat=pdf";

        request.open("post", "https://ffpdf.com/api/ConvertLog/DocToPdf?id=" + params);
        // request.setRequestHeader("Content-type", "multipart/form-data");
        request.setRequestHeader("Authorization", commonHeader)
        request.send();

        request.onload = function () {
            console.log(request.response)
            chulijieguo = JSON.parse(request.response);

            
            if (chulijieguo) {
               
                let resultItemObject = {}
                let reusltItemFilename = chuliwenjianming;
                let reusltItemLink = 'https://ffpdf.com/api/ConvertLog/downloadFile/' + chulijieguo.DistFileID;
                let resultItemTime = new Date().Format("yyyy-MM-dd HH:mm:ss");
                resultItemObject['reusltItemFilename'] = reusltItemFilename;
                resultItemObject['reusltItemLink'] = reusltItemLink;
                resultItemObject['resultItemTime'] = resultItemTime;
                if (cates.length == 0) {
                    cates.push(resultItemObject);
                } else {
                    for (let i = cates.length - 1; i >= 0; i--) {

                        if (cates[i].reusltItemFilename == resultItemObject.reusltItemFilename) {
                            console.log(cates)
                            cates.splice(i, 1);
                        }
                    }
                    cates.push(resultItemObject);
                }
            };
            timeoutLocalSave(cates);
        }

    }
}

function getUploadInfo(responseItem, chuliwenjianming) {
    // let chulijindu = false;
    var timeId = setInterval(() => {

        if (responseItem.file_key) {
            let request = new XMLHttpRequest();
            // let params = 'file_key=' + responseItem.file_key + '&handle_type=' + "word2pdf";
            let params = responseItem.Id;
            request.open("post", "https://ffpdf.com/api/ConvertLog/Converting?" + params);
            // request.setRequestHeader("Content-type", "multipart/form-data");
            request.send();
            request.onload = function () {
                chulijieguo = JSON.parse(request.response);
                console.log(request.response)
                if (chulijieguo && (chulijieguo.success = true)) {

                    clearInterval(timeId)
                    let resultItemObject = {}
                    // let resultP = document.getElementById("xiazaidizhiP");

                    let reusltItemFilename = chuliwenjianming;
                    let reusltItemLink = 'https://ffpdf.com/api/ConvertLog/downloadFile?' + params;
                    let resultItemTime = new Date().Format("yyyy-MM-dd HH:mm:ss");
                    resultItemObject['reusltItemFilename'] = reusltItemFilename;
                    resultItemObject['reusltItemLink'] = reusltItemLink;
                    resultItemObject['resultItemTime'] = resultItemTime;
                    if (cates.length == 0) {
                        cates.push(resultItemObject);
                    } else {
                        for (let i = cates.length - 1; i >= 0; i--) {

                            if (cates[i].reusltItemFilename == resultItemObject.reusltItemFilename) {
                                console.log(cates)
                                cates.splice(i, 1);
                            }
                        }
                        cates.push(resultItemObject);
                    }
                };
                timeoutLocalSave(cates);


                // console.log(localTest); 
            }

        }

    }, 1000)
}

Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "H+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S": this.getMilliseconds()
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}



function timeoutLocalSave(newarr) {
    layui.data('allFileList', {
        key: 'forDownloadFilelist',
        value: newarr
    });
    var localData = layui.data('allFileList').forDownloadFilelist;
    if (layui.data('allFileList') && localData) {

        // console.log(data.length)
        var data = {
            "title": "Layui Title"
            , "list": localData
        }
        var t = setTimeout(function () {
            var getTpl = demo.innerHTML;
            view = document.getElementById('view');
            document.getElementById('demo').style.visibility = "visible";
            layui.laytpl(getTpl).render(data, function (html) {
                view.innerHTML = html;
            });
        }, 50000);

    }
}
