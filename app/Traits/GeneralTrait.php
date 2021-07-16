<?php

namespace App\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
trait GeneralTrait
{
    public function customValidate($request,$validateRules){

        $messages=[
            'accepted' => 'The :attribute must be accepted.',
            'active_url' => 'The :attribute is not a valid URL.',
            'after' => 'The :attribute must be a date after :date.',
            'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
            'alpha' => 'The :attribute may only contain letters.',
            'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
            'alpha_num' => 'The :attribute may only contain letters and numbers.',
            'array' => 'The :attribute must be an array.',
            'before' => 'The :attribute must be a date before :date.',
            'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
            'between' => [
                'numeric' => 'The :attribute must be between :min and :max.',
                'file' => 'The :attribute must be between :min and :max kilobytes.',
                'string' => 'The :attribute must be between :min and :max characters.',
                'array' => 'The :attribute must have between :min and :max items.',
            ],
            'boolean' => 'The :attribute field must be true or false.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'date' => 'The :attribute is not a valid date.',
            'date_equals' => 'The :attribute must be a date equal to :date.',
            'date_format' => 'The :attribute does not match the format :format.',
            'different' => 'The :attribute and :other must be different.',
            'digits' => 'The :attribute must be :digits digits.',
            'digits_between' => 'The :attribute must be between :min and :max digits.',
            'dimensions' => 'The :attribute has invalid image dimensions.',
            'distinct' => 'The :attribute field has a duplicate value.',
            'email' => 'The :attribute must be a valid email address.',
            'ends_with' => 'The :attribute must end with one of the following: :values.',
            'exists' => 'The selected :attribute is invalid.',
            'file' => 'The :attribute must be a file.',
            'filled' => 'The :attribute field must have a value.',
            'gt' => [
                'numeric' => 'The :attribute must be greater than :value.',
                'file' => 'The :attribute must be greater than :value kilobytes.',
                'string' => 'The :attribute must be greater than :value characters.',
                'array' => 'The :attribute must have more than :value items.',
            ],
            'gte' => [
                'numeric' => 'The :attribute must be greater than or equal :value.',
                'file' => 'The :attribute must be greater than or equal :value kilobytes.',
                'string' => 'The :attribute must be greater than or equal :value characters.',
                'array' => 'The :attribute must have :value items or more.',
            ],
            'image' => 'The :attribute must be an image.',
            'in' => 'The selected :attribute is invalid.',
            'in_array' => 'The :attribute field does not exist in :other.',
            'integer' => 'The :attribute must be an integer.',
            'ip' => 'The :attribute must be a valid IP address.',
            'ipv4' => 'The :attribute must be a valid IPv4 address.',
            'ipv6' => 'The :attribute must be a valid IPv6 address.',
            'json' => 'The :attribute must be a valid JSON string.',
            'lt' => [
                'numeric' => 'The :attribute must be less than :value.',
                'file' => 'The :attribute must be less than :value kilobytes.',
                'string' => 'The :attribute must be less than :value characters.',
                'array' => 'The :attribute must have less than :value items.',
            ],
            'lte' => [
                'numeric' => 'The :attribute must be less than or equal :value.',
                'file' => 'The :attribute must be less than or equal :value kilobytes.',
                'string' => 'The :attribute must be less than or equal :value characters.',
                'array' => 'The :attribute must not have more than :value items.',
            ],
            'max' => [
                'numeric' => 'The :attribute may not be greater than :max.',
                'file' => 'The :attribute may not be greater than :max kilobytes.',
                'string' => 'The :attribute may not be greater than :max characters.',
                'array' => 'The :attribute may not have more than :max items.',
            ],
            'mimes' => 'The :attribute must be a file of type: :values.',
            'mimetypes' => 'The :attribute must be a file of type: :values.',
            'min' => [
                'numeric' => 'The :attribute must be at least :min.',
                'file' => 'The :attribute must be at least :min kilobytes.',
                'string' => 'The :attribute must be at least :min characters.',
                'array' => 'The :attribute must have at least :min items.',
            ],
            'not_in' => 'The selected :attribute is invalid.',
            'not_regex' => 'The :attribute format is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'password' => 'The password is incorrect.',
            'present' => 'The :attribute field must be present.',
            'regex' => 'The :attribute format is invalid.',
            'required' => 'The :attribute field is required.',
            'required_if' => 'The :attribute field is required when :other is :value.',
            'required_unless' => 'The :attribute field is required unless :other is in :values.',
            'required_with' => 'The :attribute field is required when :values is present.',
            'required_with_all' => 'The :attribute field is required when :values are present.',
            'required_without' => 'The :attribute field is required when :values is not present.',
            'required_without_all' => 'The :attribute field is required when none of :values are present.',
            'same' => 'The :attribute and :other must match.',
            'size' => [
                'numeric' => 'The :attribute must be :size.',
                'file' => 'The :attribute must be :size kilobytes.',
                'string' => 'The :attribute must be :size characters.',
                'array' => 'The :attribute must contain :size items.',
            ],
            'starts_with' => 'The :attribute must start with one of the following: :values.',
            'string' => 'The :attribute must be a string.',
            'timezone' => 'The :attribute must be a valid zone.',
            'unique' => 'The :attribute has already been taken.',
            'uploaded' => 'The :attribute failed to upload.',
            'url' => 'The :attribute format is invalid.',
            'uuid' => 'The :attribute must be a valid UUID.',

            'custom' => [
                'attribute-name' => [
                    'rule-name' => 'custom-message',
                ],
            ],
            'attributes' => [
                "name"=>"name",
                "username"=>"username",
                "email"=>"email",
                "first_name"=>"first_name",
                "last_name"=>"last_name",
                "password"=>"password",
                "password_confirmation"=>"password_confirmation",
                "city"=>"city",
                "country"=>"country",
                "address"=>"address",
                "phone"=>"phone",
                "mobile"=>"mobile",
                "age"=>"age",
                "sex"=>"sex",
                "gender"=>"gender",
                "day"=>"day",
                "month"=>"month",
                "year"=>"year",
                "hour"=>"hour",
                "minute"=>"minute",
                "second"=>"second",
                "title"=>"title",
                "content"=>"content",
                "description"=>"description",
                "excerpt"=>"excerpt",
                "date"=>"date",
            ],

        ];
        $error= \Validator::make($request->all(),$validateRules,$messages);
        if($error->fails()) {
            return [
                'status' => false,
                'errorNum' => 400,
                'msg' => 'error validation',
                'errors' => $error->errors()->all(),
            ];
        }
        else return [];

    }
    public function deletePath($path){
        return \File::deleteDirectory($path);
    }
    public function returnError($msg,$errNUM=403){
        return response()->json([
            'status'=>false,
            'errorNum'=>$errNUM,
            'msg'=>$msg
        ]);
    }
    public function returnSuccess($msg='',$errNUM='S000'){
        return response()->json([
                    'status'=>true,
                    'errorNum'=>$errNUM,
                    'msg'=>$msg
        ]);
    }

    public function move_image($image,$path){
        $destinationPath = public_path($path);
        $file_name = 'img_'.time().rand(1,600) . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $file_name);
        return $path.$file_name;
    }

    public function saveBase64img($image_64,$path){
        $DIS=DIRECTORY_SEPARATOR;
        $extension=explode('/', explode(';', $image_64)[0])[1];
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        if(!$this->endsWith($path,$DIS)){
            $path=$path.$DIS;
        }
        $imageName = time().'.'.$extension;
        $path = public_path($path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $status = file_put_contents($path . $imageName, base64_decode($image));
        return $imageName;
    }

    function endsWith($haystack, $needle)
    {
        $count = strlen($needle);
        if ($count == 0) {
            return true;
        }
        return (substr($haystack, -$count) === $needle);
    }
    public function returnData($key,$value,$msg='',$errNUM='S000',$status=true){
        return response()->json([
                    'status'=>$status,
                    'errorNum'=>$errNUM,
                    'msg'=>$msg,
                    $key=>$value,


        ]);
    }
    public function ValidateData($request,$validateRules=[]){
        $messages=[
            'accepted' => 'The :attribute must be accepted.',
            'active_url' => 'The :attribute is not a valid URL.',
            'after' => 'The :attribute must be a date after :date.',
            'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
            'alpha' => 'The :attribute may only contain letters.',
            'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
            'alpha_num' => 'The :attribute may only contain letters and numbers.',
            'array' => 'The :attribute must be an array.',
            'before' => 'The :attribute must be a date before :date.',
            'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
            'between' => [
                'numeric' => 'The :attribute must be between :min and :max.',
                'file' => 'The :attribute must be between :min and :max kilobytes.',
                'string' => 'The :attribute must be between :min and :max characters.',
                'array' => 'The :attribute must have between :min and :max items.',
            ],
            'boolean' => 'The :attribute field must be true or false.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'date' => 'The :attribute is not a valid date.',
            'date_equals' => 'The :attribute must be a date equal to :date.',
            'date_format' => 'The :attribute does not match the format :format.',
            'different' => 'The :attribute and :other must be different.',
            'digits' => 'The :attribute must be :digits digits.',
            'digits_between' => 'The :attribute must be between :min and :max digits.',
            'dimensions' => 'The :attribute has invalid image dimensions.',
            'distinct' => 'The :attribute field has a duplicate value.',
            'email' => 'The :attribute must be a valid email address.',
            'ends_with' => 'The :attribute must end with one of the following: :values.',
            'exists' => 'The selected :attribute is invalid.',
            'file' => 'The :attribute must be a file.',
            'filled' => 'The :attribute field must have a value.',
            'gt' => [
                'numeric' => 'The :attribute must be greater than :value.',
                'file' => 'The :attribute must be greater than :value kilobytes.',
                'string' => 'The :attribute must be greater than :value characters.',
                'array' => 'The :attribute must have more than :value items.',
            ],
            'gte' => [
                'numeric' => 'The :attribute must be greater than or equal :value.',
                'file' => 'The :attribute must be greater than or equal :value kilobytes.',
                'string' => 'The :attribute must be greater than or equal :value characters.',
                'array' => 'The :attribute must have :value items or more.',
            ],
            'image' => 'The :attribute must be an image.',
            'in' => 'The selected :attribute is invalid.',
            'in_array' => 'The :attribute field does not exist in :other.',
            'integer' => 'The :attribute must be an integer.',
            'ip' => 'The :attribute must be a valid IP address.',
            'ipv4' => 'The :attribute must be a valid IPv4 address.',
            'ipv6' => 'The :attribute must be a valid IPv6 address.',
            'json' => 'The :attribute must be a valid JSON string.',
            'lt' => [
                'numeric' => 'The :attribute must be less than :value.',
                'file' => 'The :attribute must be less than :value kilobytes.',
                'string' => 'The :attribute must be less than :value characters.',
                'array' => 'The :attribute must have less than :value items.',
            ],
            'lte' => [
                'numeric' => 'The :attribute must be less than or equal :value.',
                'file' => 'The :attribute must be less than or equal :value kilobytes.',
                'string' => 'The :attribute must be less than or equal :value characters.',
                'array' => 'The :attribute must not have more than :value items.',
            ],
            'max' => [
                'numeric' => 'The :attribute may not be greater than :max.',
                'file' => 'The :attribute may not be greater than :max kilobytes.',
                'string' => 'The :attribute may not be greater than :max characters.',
                'array' => 'The :attribute may not have more than :max items.',
            ],
            'mimes' => 'The :attribute must be a file of type: :values.',
            'mimetypes' => 'The :attribute must be a file of type: :values.',
            'min' => [
                'numeric' => 'The :attribute must be at least :min.',
                'file' => 'The :attribute must be at least :min kilobytes.',
                'string' => 'The :attribute must be at least :min characters.',
                'array' => 'The :attribute must have at least :min items.',
            ],
            'not_in' => 'The selected :attribute is invalid.',
            'not_regex' => 'The :attribute format is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'password' => 'The password is incorrect.',
            'present' => 'The :attribute field must be present.',
            'regex' => 'The :attribute format is invalid.',
            'required' => 'The :attribute field is required.',
            'required_if' => 'The :attribute field is required when :other is :value.',
            'required_unless' => 'The :attribute field is required unless :other is in :values.',
            'required_with' => 'The :attribute field is required when :values is present.',
            'required_with_all' => 'The :attribute field is required when :values are present.',
            'required_without' => 'The :attribute field is required when :values is not present.',
            'required_without_all' => 'The :attribute field is required when none of :values are present.',
            'same' => 'The :attribute and :other must match.',
            'size' => [
                'numeric' => 'The :attribute must be :size.',
                'file' => 'The :attribute must be :size kilobytes.',
                'string' => 'The :attribute must be :size characters.',
                'array' => 'The :attribute must contain :size items.',
            ],
            'starts_with' => 'The :attribute must start with one of the following: :values.',
            'string' => 'The :attribute must be a string.',
            'timezone' => 'The :attribute must be a valid zone.',
            'unique' => 'The :attribute has already been taken.',
            'uploaded' => 'The :attribute failed to upload.',
            'url' => 'The :attribute format is invalid.',
            'uuid' => 'The :attribute must be a valid UUID.',

            'custom' => [
                'attribute-name' => [
                    'rule-name' => 'custom-message',
                ],
            ],
            'attributes' => [
                "name"=>"name",
                "username"=>"username",
                "email"=>"email",
                "first_name"=>"first_name",
                "last_name"=>"last_name",
                "password"=>"password",
                "password_confirmation"=>"password_confirmation",
                "city"=>"city",
                "country"=>"country",
                "address"=>"address",
                "phone"=>"phone",
                "mobile"=>"mobile",
                "age"=>"age",
                "sex"=>"sex",
                "gender"=>"gender",
                "day"=>"day",
                "month"=>"month",
                "year"=>"year",
                "hour"=>"hour",
                "minute"=>"minute",
                "second"=>"second",
                "title"=>"title",
                "content"=>"content",
                "description"=>"description",
                "excerpt"=>"excerpt",
                "date"=>"date",
            ],

            ];
        $error= \Validator::make($request->all(),$validateRules,$messages);
        if($error->fails()) {
            return [
                'status' => false,
                'errorNum' => 403,
                'msg' => 'error validation',
                'errors' => $error->errors()->all(),
            ];
        }
        else return [];
    }

}

