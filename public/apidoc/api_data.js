define({ "api": [  {    "type": "put",    "url": "/feedback/finfished/:id",    "title": "更新完成状态",    "version": "1.0.0",    "name": "feedback_finfished",    "group": "Feedback",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "integer",            "optional": false,            "field": "id",            "description": "<p>反馈信息Id</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n  \"status\": \"success\",\n  \"code\": 200,\n  \"message\": \"操作成功\",\n  \"data\": []\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/FeedbackController.php",    "groupTitle": "Feedback"  },  {    "type": "get",    "url": "/feedback/:state",    "title": "获取列表",    "version": "1.0.0",    "name": "feedback_list",    "group": "Feedback",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "state",            "description": "<p>反馈信息处理状态.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"data\": [\n   {\n     \"contact\": \"18610320751\",\n     \"content\": \"这是2个意见反馈！！！\"\n   },\n   {\n     \"contact\": \"18610320751\",\n     \"content\": \"这是一个意见反馈！！！\"\n   }\n ],\n \"meta\": {\n   \"status\": \"success\",\n   \"code\": 200,\n   \"message\": \"获取反馈信息列表成功\",\n   \"pagination\": {\n     \"total\": 2,\n     \"count\": 2,\n     \"per_page\": 20,\n     \"current_page\": 1,\n     \"total_pages\": 1,\n     \"links\": []\n   }\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/FeedbackController.php",    "groupTitle": "Feedback"  },  {    "type": "post",    "url": "/feedback/submit",    "title": "提交信息",    "version": "1.0.0",    "name": "feedback_submit",    "group": "Feedback",    "success": {      "fields": {        "Success 200": [          {            "group": "Success 200",            "type": "String",            "optional": false,            "field": "contact",            "description": "<p>联系方式</p>"          },          {            "group": "Success 200",            "type": "String",            "optional": false,            "field": "content",            "description": "<p>反馈内容</p>"          }        ]      },      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"data\": {\n        \"contact\":\"44334512\",\n        \"content\":\"提交一个测试反馈信息\"\n     },\n    \"meta\": {\n        \"status\": \"success\",\n        \"status_code\": 200,\n        \"message\": \"提交反馈信息成功\"\n    }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "失败响应:",          "content": "{\n    \"message\": \"提交反馈信息失败\",\n    \"status_code\": 404\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/FeedbackController.php",    "groupTitle": "Feedback"  },  {    "type": "post",    "url": "/stuffs/:id/comments",    "title": "某个分享的评论列表",    "version": "1.0.0",    "name": "stuff_comments",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>分享ID.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"data\": [\n    {\n         \"id\": 3,\n        \"content\": \"这是一条评论内容精选\",\n        \"user\": {\n          \"id\": 1,\n          \"username\": \"xiaobeng\",\n          \"summary\": null\n        },\n        \"like_count\": 0\n      }\n ],\n \"meta\": {\n      \"message\": \"Success.\",\n      \"status_code\": 200,\n      \"pagination\": {\n        \"total\": 4,\n        \"count\": 2,\n        \"per_page\": 2,\n        \"current_page\": 1,\n        \"total_pages\": 2,\n        \"links\": {\n          \"next\": \"http://xxxx/api/stuffs/1/comments?page=2\"\n        }\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/:id/destory",    "title": "删除分享信息",    "version": "1.0.0",    "name": "stuff_destory",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>回复Id.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"meta\": {\n   \"code\": 200,\n   \"message\": \"Success.\",\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/:id/destoryComment",    "title": "删除回复",    "version": "1.0.0",    "name": "stuff_destory_comment",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>回复Id.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"meta\": {\n   \"status\": \"success\",\n   \"code\": 200,\n   \"message\": \"删除成功\",\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/:id/cancelLike",    "title": "取消喜欢",    "version": "1.0.0",    "name": "stuff_destory_like",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>喜欢Id.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"meta\": {\n   \"status\": \"success\",\n   \"code\": 200,\n   \"message\": \"取消成功\",\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/:id/dolike",    "title": "点赞",    "version": "1.0.0",    "name": "stuff_dolike",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>分享ID.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"data\": [\n     \"id\": 28,\n      \"likeable\": {\n        \"id\": 1,\n        \"user_id\": 1,\n        \"asset\": {\n          \"id\": 7,\n          \"type\": 1,\n          \"filepath\": \"uploads/images/d80b538b2c3c98cac393a81bb81cf0e9.jpg\",\n          \"size\": 77465,\n        },\n        \"content\": \"开始上传文件\",\n        \"tags\": \"\",\n        \"sticked\": 1,\n        \"featured\": 1,\n        \"view_count\": 0,\n        \"like_count\": 13,\n        \"comment_count\": -2,\n      },\n      \"user\": {\n        \"id\": 1,\n        \"username\": \"xiaobeng\",\n        \"summary\": null\n      }\n ],\n \"meta\": {\n   \"status\": \"success\",\n   \"code\": 200,\n   \"message\": \"删除成功\",\n }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "错误响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"操作失败！\",\n    \"status_code\": 200\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/:id/likes",    "title": "某个分享的喜欢列表",    "version": "1.0.0",    "name": "stuff_likes",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>分享ID.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"data\": [\n    {\n      \"id\": 28,\n      \"likeable\": {\n        \"id\": 1,\n        \"user_id\": 1,\n        \"asset\": {\n          \"id\": 7,\n          \"type\": 1,\n          \"filepath\": \"uploads/images/d80b538b2c3c98cac393a81bb81cf0e9.jpg\",\n          \"size\": 77465,\n        },\n        \"content\": \"开始上传文件\",\n        \"tags\": \"\",\n        \"sticked\": 1,\n        \"featured\": 1,\n        \"view_count\": 0,\n        \"like_count\": 13,\n        \"comment_count\": -2,\n      },\n      \"user\": {\n        \"id\": 1,\n        \"username\": \"xiaobeng\",\n        \"summary\": null\n      }\n   }\n ],\n \"meta\": {\n      \"message\": \"Success.\",\n      \"status_code\": 200,\n      \"pagination\": {\n        \"total\": 4,\n        \"count\": 2,\n        \"per_page\": 2,\n        \"current_page\": 1,\n        \"total_pages\": 2,\n        \"links\": {\n          \"next\": \"http://xxxx/api/stuffs/1/likes?page=2\"\n        }\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "get",    "url": "/stuffs",    "title": "获取分享列表",    "version": "1.0.0",    "name": "stuff_list",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "page",            "description": "<p>当前分页.</p>"          },          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "per_page",            "description": "<p>每页数量</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"data\": [\n        {\n            \"id\": 10,\n            \"content\": \"这是重大的设计走势\",\n            \"user_id\": 10,\n            \"user\": {\n                  \"id\": 1,\n                  \"account\": \"purpen.w@gmail.com\",\n                  \"username\": \"purpen\",\n                  \"email\": null,\n                  \"phone\": \"\",\n                  \"avatar_url\": \"\",\n                  \"job\": \"\",\n                  \"zone\": \"\",\n                  \"sex\": 0,\n                  \"summary\": null,\n                  \"follow_count\": 0,\n                  \"fans_count\": 0,\n                  \"stuff_count\": 0,\n                  \"like_count\": 0,\n                  \"tags\": null,\n                  \"updated_at\": \"2016-08-01 18:42:06\"\n                },\n            \"tags\": \"\",\n            \"asset_id\": 23\n        },\n        {\n            \"id\": 9,\n            \"content\": \"这是重大的设计\",\n            \"user_id\": 0,\n            \"user\": {\n               ...\n             }\n            \"tags\": \"\",\n            \"asset_id\": 22\n        }\n    ],\n    \"meta\": {\n        \"message\": \"Success.\",\n        \"status_code\": 200,\n        \"pagination\": {\n            \"total\": 10,\n            \"count\": 2,\n            \"per_page\": 2,\n            \"current_page\": 1,\n            \"total_pages\": 5,\n            \"links\": {\n                \"next\": \"http://fifish.me/api/stuffs?page=2\"\n            }\n        }\n    }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/:id/postComment",    "title": "发表回复",    "version": "1.0.0",    "name": "stuff_post_comment",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "content",            "description": "<p>回复内容.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"data\": [\n      \"id\": 5,\n      \"content\": \"这是一条评论内容精选大家电\",\n      \"user\": {\n          \"id\": 1,\n          \"username\": \"xiaobeng\",\n          \"summary\": null\n        },,\n      \"like_count\": null\n ],\n \"meta\": {\n   \"status\": \"success\",\n   \"code\": 200,\n   \"message\": \"回复成功\",\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "get",    "url": "/stuffs/:id",    "title": "显示分享详情",    "version": "1.0.0",    "name": "stuff_show",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>回复Id.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"data\": [\n    \"id\": 11,\n    \"content\": \"这是一个新世界sdfsadfasdf\",\n   \"user_id\": 1,\n      \"user\": {\n        \"id\": 1,\n        \"account\": \"purpen.w@gmail.com\",\n        \"username\": \"purpen\",\n         ...\n      },\n      \"tags\": \"\",\n      \"asset_id\": 1\n ],\n \"meta\": {\n   \"status\": \"success\",\n   \"code\": 200,\n   \"message\": \"获取成功\",\n }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "错误响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"Not Found！\",\n    \"status_code\": 404\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "post",    "url": "/stuffs/store",    "title": "新增分享信息",    "version": "1.0.0",    "name": "stuff_store",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "String",            "optional": false,            "field": "content",            "description": "<p>分享内容</p>"          },          {            "group": "Parameter",            "type": "File",            "optional": false,            "field": "file",            "description": "<p>上传文件</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n  \"data\": {\n    \"id\": 10,\n    \"content\": \"这是重大的设计走势\",\n    \"user_id\": 10,\n    \"tags\": null,\n    \"asset_id\": \"23\"\n  },\n  \"meta\": {\n    \"message\": \"Success.\",\n    \"status_code\": 200\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "put",    "url": "/stuffs/:id/update",    "title": "更新分享信息",    "version": "1.0.0",    "name": "stuff_update",    "group": "Stuff",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "Integer",            "optional": false,            "field": "id",            "description": "<p>回复Id.</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n \"meta\": {\n   \"code\": 200,\n   \"message\": \"Success.\",\n }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/StuffController.php",    "groupTitle": "Stuff"  },  {    "type": "get",    "url": "/upload/qiniuback",    "title": "云上传回调地址(七牛)",    "version": "1.0.0",    "name": "upload_asset",    "group": "Upload",    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"meta\": {\n      \"message\": \"request ok\",\n      \"status_code\": 200\n    },\n    \"data\": {\n        \"imageUrl\": \"http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg\"\n    }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/UploadController.php",    "groupTitle": "Upload"  },  {    "type": "post",    "url": "/upload/avatar",    "title": "更新用户头像",    "version": "1.0.0",    "name": "upload_avatar",    "group": "Upload",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "avatar",            "description": "<p>上传文件</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"meta\": {\n      \"message\": \"request ok\",\n      \"status_code\": 200\n    },\n    \"data\": {\n        \"imageUrl\": \"http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg\"\n    }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "错误响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"Not Found！\",\n    \"status_code\": 404\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/UploadController.php",    "groupTitle": "Upload"  },  {    "type": "get",    "url": "/upload/qiniuToken",    "title": "获取云上传token(七牛)",    "version": "1.0.0",    "name": "upload_token",    "group": "Upload",    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"meta\": {\n      \"message\": \"request ok\",\n      \"status_code\": 200\n    },\n    \"data\": {\n        \"qiniu_token\": \"lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0=\"\n      }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/UploadController.php",    "groupTitle": "Upload"  },  {    "type": "get",    "url": "/upload/video",    "title": "本地上传视频",    "version": "1.0.0",    "name": "upload_video",    "group": "Upload",    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"meta\": {\n      \"message\": \"request ok\",\n      \"status_code\": 200\n    },\n    \"data\": {\n        \"imageUrl\": \"http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg\"\n    }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "错误响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"Not Found！\",\n    \"status_code\": 404\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/UploadController.php",    "groupTitle": "Upload"  },  {    "type": "post",    "url": "/auth/login",    "title": "用户登录",    "version": "1.0.0",    "name": "user_login",    "group": "User",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "account",            "description": "<p>用户账号（要求邮箱格式）</p>"          },          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "password",            "description": "<p>设置密码</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"code\": 200,\n    \"message\": \"登录成功！\",\n    \"data\": {\n      \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2ZpZmlzaC5tZVwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTQ2OTg4NjExNCwiZXhwIjoxNDY5ODg5NzE0LCJuYmYiOjE0Njk4ODYxMTQsImp0aSI6IjAxN2JhNTRjNjJjMWU0ZWM4OTU1YzExYjg0MDk0YjIxIn0.G25OQH2047nC9_DLyfc6s88cm_5IdYuhIVxYgXGsDjk\"\n   }\n  }",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/AuthenticateController.php",    "groupTitle": "User"  },  {    "type": "post",    "url": "/auth/logout 退出登录",    "title": "要求：收到响应后，同时客户端清除token",    "version": "1.0.0",    "name": "user_logout",    "group": "User",    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"code\": 200,\n    \"message\": \"退出成功！\",\n    \"data\": {\n      \"res\": true | false\n   }\n  }",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/AuthenticateController.php",    "groupTitle": "User"  },  {    "type": "get",    "url": "/user/profile",    "title": "获取个人信息",    "version": "1.0.0",    "name": "user_profile",    "group": "User",    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n  \"data\": {\n    \"id\": 1,\n    \"account\": \"purpen.w@gmail.com\",\n    \"username\": \"purpen\",\n    \"job\": \"设计师\",\n    \"zone\": \"北京\",\n    \"avatar\": {\n      \"small\": \"\",\n      \"large\": \"\"\n   }\n  },\n  \"meta\": {\n    \"meta\": {\n      \"message\": \"request ok\",\n      \"status_code\": 200\n    }\n  }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "错误响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"Not Found！\",\n    \"status_code\": 404\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/UserController.php",    "groupTitle": "User"  },  {    "type": "post",    "url": "/auth/register",    "title": "用户注册",    "version": "1.0.0",    "name": "user_register",    "group": "User",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "account",            "description": "<p>用户账号（要求邮箱格式）</p>"          },          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "password",            "description": "<p>设置密码</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n  \"status\": \"success\",  \n  \"code\": 200,\n  \"message\": \"注册成功\",\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/AuthenticateController.php",    "groupTitle": "User"  },  {    "type": "post",    "url": "/user/settings",    "title": "设置个人资料",    "version": "1.0.0",    "name": "user_settings",    "group": "User",    "parameter": {      "fields": {        "Parameter": [          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "username",            "description": "<p>用户姓名</p>"          },          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "job",            "description": "<p>职业</p>"          },          {            "group": "Parameter",            "type": "string",            "optional": false,            "field": "zone",            "description": "<p>城市/地区</p>"          }        ]      }    },    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"Success！\",\n    \"status_code\": 200\n  }\n}",          "type": "json"        }      ]    },    "error": {      "examples": [        {          "title": "错误响应:",          "content": "{\n  \"meta\": {\n    \"message\": \"Not Found！\",\n    \"status_code\": 404\n  }\n}",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/UserController.php",    "groupTitle": "User"  },  {    "type": "post",    "url": "/auth/upToken",    "title": "更新Token",    "version": "1.0.0",    "name": "user_token",    "group": "User",    "success": {      "examples": [        {          "title": "成功响应:",          "content": "{\n    \"code\": 200,\n    \"message\": \"更新Token成功！\",\n    \"data\": {\n      \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2ZpZmlzaC5tZVwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTQ2OTg4NjExNCwiZXhwIjoxNDY5ODg5NzE0LCJuYmYiOjE0Njk4ODYxMTQsImp0aSI6IjAxN2JhNTRjNjJjMWU0ZWM4OTU1YzExYjg0MDk0YjIxIn0.G25OQH2047nC9_DLyfc6s88cm_5IdYuhIVxYgXGsDjk\"\n   }\n  }",          "type": "json"        }      ]    },    "filename": "app/Http/Controllers/Api/V1/AuthenticateController.php",    "groupTitle": "User"  }] });
