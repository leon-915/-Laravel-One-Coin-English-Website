<tr>
    <td>
        {{$service->title}}
    </td>
    <td> 
        @if(empty($service->hide_price) || empty($studentDetails->hide_price))
            ¥ {{$service->price}}
        @endif       
    </td>
    <td>
        @if(!empty($service->length))
            {{$service->length}} {{$service->length_type}}
        @endif 
    </td>
    <td>
        @if(!empty($service->available_lessons))
           {{$service->available_lessons}}
        @endif 
    </td>
    <td>
        @if($service->checkAddedInCart($service->id) != 1)
            <?php $url = url('student/add-cart/' . $service->id);?>
        @else
            <?php $url = 'javascript:void(0)'?>
        @endif
        <a href="{{$url}}" class="add_cart">
            @if($service->checkAddedInCart($service->id) == 1)
                <i class="fas fa-check" style="margin-left: -18px;"></i>
            @endif
            {{__('labels.stu_add_to_cart')}}
        </a>
    </td>
</tr>
