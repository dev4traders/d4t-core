<?php
namespace D4T\Core\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use D4T\Core\Traits\HasDomain;
use D4T\Core\DomainTemplateMailable;
use Illuminate\Support\Facades\File;
use D4T\Core\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MailTemplates\Models\MailTemplate;
use D4T\Core\Contracts\MailDepartmentInterface;
use D4T\Core\Exceptions\MissingDomainMailTemplate;
use D4T\Core\Contracts\DomainMailTemplateInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainMailTemplate extends MailTemplate implements DomainMailTemplateInterface {

    use HasDateTimeFormatter;
    use HasDomain;

    const TABLE_NAME = 'domain_mail_templates';

    protected $appends = ['label'];

    public function department() : BelongsTo
    {
        return $this->belongsTo(EmailDepartment::class, 'department_id');
    }

    public function getEmailDepartment(): ?MailDepartmentInterface
    {
        return $this->department;
    }

    public function scopeForDomainMailable(Builder $query, DomainTemplateMailable $mailable): Builder
    {
        $query->where('mailable', get_class($mailable))
            ->where('domain_id', $mailable->getDomainId());

        return $query;
    }

    public static function findForDomainMailable(DomainTemplateMailable $mailable): self
    {
        $mailTemplate = static::forDomainMailable($mailable)->with('department')->first();

        if (! $mailTemplate) {
            throw MissingDomainMailTemplate::forDomainMailable($mailable);
        }

        return $mailTemplate;
    }

    public static function fillTypesForDomains() : void {
        $types = config('d4t.email_template_types');
        $domains = Domain::all();

        collect($types)->each(function ($type) use($domains) {
            $domains->each( function($domain) use($type) {

                $subject = self::labelFor($type);
                $parts = preg_split('/(?=[A-Z])/', $subject, -1, PREG_SPLIT_NO_EMPTY);
                $subject = Arr::join($parts, ' ');

                $fileName = Arr::join($parts, '_');
                $fileName = Str::of($fileName)->lower();
                $path = config('view.paths')[0];
                $fileName = $path.'/emails/'.$fileName.'.blade.php';

                $template = '';
                if(File::exists($fileName))
                    $template = File::get($fileName);

                self::insertOrIgnore([
                    'domain_id' => $domain->id,
                    'mailable' => $type,
                    'subject' => $subject,
                    'html_template' => $template,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } );
        });
    }

    public static function labelFor(string $value): string
    {
        //static::ensureImplementsInterface();
        $lang_key = 'email-templates.'.$value;

        return app('translator')->has($lang_key) ? __($lang_key) : $value;
    }

    public function label(): string
    {
        return static::labelFor($this->mailable);
    }

    public function getLabelAttribute() : string {
        return $this->label();
    }
    // public static function getTypeFromClass(string $className) : string {
    //     return Str::remove('App\\Mail\\', $className);
    // }

    // public static function getTitle(string $className) : string {
    //     return __('mail.'.self::getTypeFromClass($className));
    // }

    // public function getMailableTitleAttribute() : string {
    //     return __('email-template.'.self::getTypeFromClass($this->mailable));
    // }
}
