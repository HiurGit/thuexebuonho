<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'accepted_if' => 'Trường :attribute phải được chấp nhận khi :other là :value.',
    'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
    'after' => 'Trường :attribute phải là một ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải là thời gian bắt đầu sau hoặc bằng :date.',
    'alpha' => 'Trường :attribute chỉ được chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ được chứa các ký tự chữ cái, số, dấu gạch ngang (-) và dấu gạch dưới (_).',
    'alpha_num' => 'Trường :attribute phải là dạng chữ-số.',
    'array' => 'Trường :attribute phải là mảng.',
    'ascii' => 'Trường :attribute chỉ được phép chứa các ký tự chữ số và ký hiệu một byte.',
    'before' => 'Trường :attribute phải là một ngày trước :date.',
    'before_or_equal' => 'Trường :attribute phải là thời gian bắt đầu trước hoặc bằng :date.',
    'between' => [
        'array' => 'Trường :attribute phải lớn hơn :min và nhỏ hơn :max phần tử.',
        'file' => 'Dung lượng file :attribute phải trong khoảng :min và :max kilobytes.',
        'numeric' => 'Trường :attribute phải nằm giữa :min và :max.',
        'string' => 'Trường :attribute phải có độ dài từ :min đến :max ký tự.',
    ],
    'boolean' => 'Trường :attribute phải là true hoặc false.',
    'can' => 'Trường :attribute chứa một giá trị trái phép.',
    'confirmed' => 'Trường xác nhận :attribute không khớp.',
    'contains' => 'Trường :attribute thiếu một giá trị bắt buộc.',
    'current_password' => 'Mật khẩu không đúng.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_equals' => 'Trường :attribute phải là một ngày bằng với :date.',
    'date_format' => 'Trường :attribute phải có định dạng :format.',
    'decimal' => 'Trường :attribute phải có :decimal chữ số thập phân.',
    'declined' => 'Trường :attribute phải từ chối.',
    'declined_if' => 'Trường :attribute phải từ chối khi :other là :value.',
    'different' => 'Trường :attribute và :other phải khác nhau.',
    'digits' => 'Độ dài của trường :attribute phải gồm :digits chữ số.',
    'digits_between' => 'Độ dài của trường :attribute phải nằm trong khoảng :min và :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị trùng lặp.',
    'doesnt_end_with' => 'Trường :attribute không được kết thúc bằng những giá trị sau: :values.',
    'doesnt_start_with' => 'Trường :attribute không được bắt đầu bằng những giá trị sau: :values.',
    'email' => 'Trường :attribute không hợp lệ.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong những giá trị sau: :values',
    'enum' => 'Giá trị đã chọn của trường :attribute không hợp lệ.',
    'exists' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'extensions' => 'Trường :attribute phải có một trong những phần mở rộng sau: :values.',
    'file' => 'Trường :attribute phải là một tệp tin.',
    'filled' => 'Trường :attribute không được bỏ trống.',
    'gt' => [
        'array' => 'Trường :attribute phải có nhiều hơn :value phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute phải lớn hơn :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải lớn hơn :value.',
        'string' => 'Độ dài trường :attribute phải lớn hơn :value ký tự.',
    ],
    'gte' => [
        'array' => 'Trường :attribute phải có ít nhất :value phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải lớn hơn hoặc bằng :value.',
        'string' => 'Độ dài trường :attribute phải lớn hơn hoặc bằng :value ký tự.',
    ],
    'hex_color' => 'Trường :attribute phải là màu dạng hex hợp lệ.',
    'image' => 'Trường :attribute phải là dạng hình ảnh.',
    'in' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'in_array' => 'Trường :attribute phải thuộc một trong các giá trị của :other.',
    'integer' => 'Trường :attribute phải là số nguyên.',
    'ip' => 'Trường :attribute phải là một địa chỉ IP.',
    'ipv4' => 'Trường :attribute phải là một địa chỉ IPv4.',
    'ipv6' => 'Trường :attribute phải là một địa chỉ IPv6.',
    'json' => 'Trường :attribute phải là một chuỗi JSON hợp lệ.',
    'lowercase' => 'Trường :attribute phải ở dạng chữ thường.',
    'lt' => [
        'array' => 'Trường :attribute phải có ít hơn :value phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute phải nhỏ hơn :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải nhỏ hơn :value.',
        'string' => 'Độ dài trường :attribute phải nhỏ hơn :value ký tự.',
    ],
    'lte' => [
        'array' => 'Trường :attribute phải có nhiều nhất :value phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Giá trị trường :attribute phải nhỏ hơn hoặc bằng :value.',
        'string' => 'Độ dài trường :attribute phải nhỏ hơn hoặc bằng :value ký tự.',
    ],
    'mac_address' => 'Trường :attribute phải là một địa chỉ MAC hợp lệ.',
    'max' => [
        'array' => 'Trường :attribute phải có nhiều nhất :max phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute không được lớn hơn :max kilobytes.',
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
    ],
    'max_digits' => 'Trường :attribute không được chứa nhiều hơn :max chữ số.',
    'mimes' => 'Trường :attribute phải là một tệp thuộc định dạng: :values.',
    'mimetypes' => 'Trường :attribute phải là một tệp thuộc định dạng: :values.',
    'min' => [
        'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute phải tối thiểu :min kilobytes.',
        'numeric' => 'Trường :attribute phải tối thiểu là :min.',
        'string' => 'Trường :attribute phải có tối thiểu :min ký tự.',
    ],
    'min_digits' => 'Trường :attribute phải chứa ít nhất :min chữ số.',
    'missing' => 'Trường :attribute phải là trường bị thiếu.',
    'missing_if' => 'Trường :attribute phải là trường bị thiếu khi :other là :value.',
    'missing_unless' => 'Trường :attribute phải là trường bị thiếu trừ khi :other là :value.',
    'missing_with' => 'Trường :attribute phải là trường bị thiếu khi có :values.',
    'missing_with_all' => 'Trường :attribute phải là trường bị thiếu khi có tất cả các trường :values.',
    'multiple_of' => 'Trường :attribute phải là bội số của :value.',
    'not_in' => 'Giá trị đã chọn trong trường :attribute không hợp lệ.',
    'not_regex' => 'Trường :attribute có định dạng không hợp lệ.',
    'numeric' => 'Trường :attribute phải là một số.',
    'password' => [
        'letters' => 'Trường :attribute phải chứa ít nhất một chữ cái.',
        'mixed' => 'Trường :attribute phải chứa ít nhất một chữ cái hoa và một chữ cái thường.',
        'numbers' => 'Trường :attribute phải chứa ít nhất một chữ số.',
        'symbols' => 'Trường :attribute phải chứa ít nhất một ký tự đặc biệt.',
        'uncompromised' => 'Giá trị của trường :attribute đã xuất hiện trong một vụ rò rỉ dữ liệu.',
    ],
    'present' => 'Trường :attribute phải được cung cấp.',
    'present_if' => 'Trường :attribute phải có mặt khi :other là :value.',
    'present_unless' => 'Trường :attribute phải có mặt trừ khi :other là :value.',
    'present_with' => 'Trường :attribute phải có mặt khi :values có mặt.',
    'present_with_all' => 'Trường :attribute phải có mặt khi tất cả :values có mặt.',
    'prohibited' => 'Trường :attribute bị cấm.',
    'prohibited_if' => 'Trường :attribute bị cấm khi :other là :value.',
    'prohibited_unless' => 'Trường :attribute bị cấm trừ khi :other thuộc :values.',
    'prohibits' => 'Trường :attribute cấm giá trị :other cùng tồn tại.',
    'regex' => 'Trường :attribute có định dạng không hợp lệ.',
    'required' => 'Trường :attribute là bắt buộc.',
    'required_array_keys' => 'Trường :attribute phải chứa các mục cho: :values.',
    'required_if' => 'Trường :attribute là bắt buộc khi :other là :value.',
    'required_if_accepted' => 'Trường :attribute là bắt buộc khi :other được chấp nhận.',
    'required_if_declined' => 'Trường :attribute là bắt buộc khi :other từ chối.',
    'required_unless' => 'Trường :attribute là bắt buộc trừ khi :other là :values.',
    'required_with' => 'Trường :attribute là bắt buộc khi :values có mặt.',
    'required_with_all' => 'Trường :attribute là bắt buộc khi tất cả :values có mặt.',
    'required_without' => 'Trường :attribute là bắt buộc khi :values không có mặt.',
    'required_without_all' => 'Trường :attribute là bắt buộc khi không có sự xuất hiện của tất cả :values.',
    'reserved' => 'Trường :attribute không được phép sử dụng.',
    'same' => 'Trường :attribute và :other phải giống nhau.',
    'size' => [
        'array' => 'Trường :attribute phải chứa :size phần tử.',
        'file' => 'Dung lượng tệp tin trường :attribute phải bằng :size kilobytes.',
        'numeric' => 'Trường :attribute phải bằng :size.',
        'string' => 'Trường :attribute phải chứa :size ký tự.',
    ],
    'starts_with' => 'Trường :attribute phải bắt đầu bằng một trong những giá trị sau: :values',
    'string' => 'Trường :attribute phải là chuỗi ký tự.',
    'timezone' => 'Trường :attribute phải là một múi giờ hợp lệ.',
    'unique' => 'Giá trị :attribute đã tồn tại.',
    'uploaded' => 'Tệp :attribute không thể tải lên.',
    'uppercase' => 'Trường :attribute phải ở dạng in hoa.',
    'url' => 'Trường :attribute phải là một URL hợp lệ.',
    'ulid' => 'Trường :attribute phải là một ULID hợp lệ.',
    'uuid' => 'Trường :attribute phải là một chuỗi UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Họ và tên',
        'full_name' => 'Họ và tên',
        'reporter_name' => 'Họ và tên người báo cáo',
        'image' => 'Ảnh',
        'images' => 'Ảnh',
        'images.*' => 'Ảnh',
        'avatar' => 'Ảnh đại diện',
        'cccd' => 'CCCD',
        'license' => 'Số bằng lái',
        'phone' => 'Số điện thoại',
        'dob' => 'Ngày sinh',
        'gender' => 'Giới tính',
        'address' => 'Địa chỉ',
        'issue_date' => 'Ngày cấp',
        'detail' => 'Nội dung cảnh báo',
        'content' => 'Nội dung',
        'title' => 'Tiêu đề',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'current_password' => 'Mật khẩu hiện tại',
        'status' => 'Trạng thái',
        'price' => 'Giá',
        'car_id' => 'Xe',
        'car' => 'Xe',
        'vehicle' => 'Xe',
        'plate' => 'Biển số xe',
        'brand' => 'Hãng xe',
        'model' => 'Mẫu xe',
        'color' => 'Màu xe',
        'year' => 'Năm sản xuất',
        'seat' => 'Số ghế',
        'fuel' => 'Nhiên liệu',
        'rent_price' => 'Giá thuê',
        'deposit' => 'Tiền cọc',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'pickup_location' => 'Điểm đón',
        'return_location' => 'Điểm trả xe',
        'from' => 'Từ',
        'to' => 'Đến',
        'reason' => 'Lý do',
        'description' => 'Mô tả',
        'note' => 'Ghi chú',
        'link' => 'Liên kết',
        'banner' => 'Banner',
        'banner_image' => 'Ảnh banner',
        'logo' => 'Logo',
        'caption' => 'Chú thích',
        'alt' => 'Văn bản thay thế',
        'sort' => 'Thứ tự',
        'scope' => 'Phạm vi',
        'user' => 'Người dùng',
        'admin' => 'Quản trị viên',
        'password_confirmation' => 'Xác nhận mật khẩu',
        'remember' => 'Ghi nhớ đăng nhập',
    ],

];