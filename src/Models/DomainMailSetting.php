<?php

namespace D4T\Core\Models;

use D4T\Core\Traits\HasDomain;
use D4T\Core\Models\EmailDepartment;
use Illuminate\Database\Eloquent\Model;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DomainMailSetting extends Model {

    use HasDateTimeFormatter;
    use HasDomain;

    protected $primaryKey = "domain_id";
    public $incrementing = false;
    protected $fillable = ['transport', 'encryption',  'default_department_id', 'host', 'port', 'username', 'password'];

    protected $table = 'mail_settings';

    public function default_department() : HasOne {
        return $this->hasOne(EmailDepartment::class, 'id', 'default_department_id');
    }
}
