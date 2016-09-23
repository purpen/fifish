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
     *      size,width,height,mime
     *      state,created_at,updated_at
     *
     * @var string
     */
    protected $table = 'assets';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['fileurl'];
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'assetable_id', 'assetable_type', 'filepath', 'filename', 'size', 'width', 'height', 'mime'];
    
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
    protected $visible = ['id', 'filepath', 'size', 'width', 'height', 'file'];
    
    /**
     * 获取所有拥有的 assetable 模型。
     */
    public function assetable()
    {
        return $this->morphTo();
    }
    
    /**
     * 转换为KB
     */
    public function getSizeAttribute($size)
    {
        return ceil($size/1024).'KB';
    }
    
    /**
     * 获取照片/视频截图访问file
     */
    public function getFileAttribute()
    {
        if ($this->assetable_type == 'User') {
            return (object)[
                'small' => ImageUtil::qiniuViewUrl($this->filepath, 'smx50'),
                'large' => ImageUtil::qiniuViewUrl($this->filepath, 'lgx180'),
            ];
        } else {
            return (object)[
                'small' => ImageUtil::qiniuViewUrl($this->filepath, 'cvxsm'),
                'large' => ImageUtil::qiniuViewUrl($this->filepath, 'cvxlg'),
            ];
        }
    }
    
}
