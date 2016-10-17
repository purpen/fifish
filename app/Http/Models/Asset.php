<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Utils\ImageUtil;

class Asset extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: assets
     *      id,
     *      user_id,
     *      assetable_id,
     *      assetable_type,
     *      filepath,
     *      filename,
     *      duration 视频时长
     *      size,vbyte,width,height,mime
     *      state,created_at,updated_at
     *      kind // 类型：1.图片；2.视频
     *
     * @var string
     */
    protected $table = 'assets';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['file'];
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'assetable_id', 'assetable_type', 'filepath', 'filename', 'size', 'vbyte', 'width', 'height', 'mime', 'duration','kind'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['state'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'filepath', 'size', 'vbyte', 'width', 'height', 'file', 'duration', 'kind'];
    
    /**
     * 获取所有拥有的 assetable 模型。
     */
    public function assetable()
    {
        return $this->morphTo();
    }
    
    /**
     * 获取照片/视频截图访问file
     */
    public function getFileAttribute()
    {
        if ($this->assetable_type == 'User') {
            return (object)[
                'srcfile' => ImageUtil::qiniuViewUrl($this->filepath),
                'small' => ImageUtil::qiniuViewUrl($this->filepath, 'smx50'),
                'large' => ImageUtil::qiniuViewUrl($this->filepath, 'lgx180'),
            ];
        } else {
            if ($this->kind == 1) {
                return (object)[
                    'srcfile' => ImageUtil::qiniuViewUrl($this->filepath),
                    'small' => ImageUtil::qiniuViewUrl($this->filepath, 'cvxsm'),
                    'large' => ImageUtil::qiniuViewUrl($this->filepath, 'cvxlg'),
                ];
            } else {
                // 视频、文档等无缩略图
                return (object)[
                    'srcfile' => ImageUtil::qiniuViewUrl($this->filepath, 'wm'),
                    'small' => ImageUtil::qiniuViewUrl($this->filepath, 'vfrsm'),
                    'large' => ImageUtil::qiniuViewUrl($this->filepath, 'vfr'),
                ];
            }
        }
    }
    
}
