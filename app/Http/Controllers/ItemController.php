<?php

namespace App\Http\Controllers;

use PDF;
use Image;
use Picqer;
use Barcode;
//use App\Models\barcode;
use App\Models\{Regitem,User,Sales,itemimage,Itemlog,setting,Category,Salesitem,companyinfo,transaction,beginingdetail,receivingdetail,item_type};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Collection;
//use Response;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use Spatie\Permission\Models\Role;
Use Exception;
use Illuminate\Pagination\Paginator;
use App\CustomClass\barcode_generator;
use App\Notifications\itemNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Response;
use LaravelDaily\Invoices\Classes\Buyer;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function testimages(){
        $imagepath = public_path().'/itemimage/13.jpg';
        $im=public_path('itemimage/13.jpg');
        $image = base64_encode(file_get_contents($imagepath));
        $newimg="https://apis.opalaconsult.com/face_recognition/default.png";
        $apiurlval="http://192.168.0.139/action/AddPerson";
        return Http::withBasicAuth('admin','admin')
        ->post($apiurlval,[
            'operator'=>"AddPerson",
            'info'=>[
                "DeviceID"=>"2361921",
                "PersonType"=> 0,
                "Name"=>"test",
                "Gender"=>0,
                "Nation"=>0,
                "CardType"=>0,
                "IdCard"=>"430923199011044411",
                "Birthday"=>"1990-11-04", 
                "Telnum"=>"18888888888",
                "Native"=>"0",
                "Address"=>"AA",
                "Notes"=>"sasa",
                "MjCardFrom"=> 0,
                "MjCardNo"=> 1234,
                "Tempvalid"=> 0,
                "CustomizeID"=> 123456,
                "PersonUUID"=> "4476c20c-23ce-4178-8672-b292d33a3cd8",
                "ValidBegin"=>"2019-03-12T09:09:20",  
                "ValidEnd"=>"2023-11-23T09:09:20",
            ],
            // "picURI"=>"https://apis.opalaconsult.com/face_recognition/default.png"
            "picinfo"=>"data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCACMAIwDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwDgPJ+bpT1j61c8mhYSBXziPGRieJ9Yj8OaBeX8u4iJCQq43E9gM96+O/Fvjy/8RXrTXDkspyNzcj0A/wDrV9EftG6wum+E4raO5khmnY/JGeqgc7uen518jrHJd3IRQWYmvVoJKN2epQj7tydZJr6ZI1Bd2OAqj1rtbD4azJEslxyxwSoH6V13wl+HSrIl9dIC38IxnFen3GgxvGf3YDE4GK8+vjuWXLA+jw+CvHmnueNaT4HSa4bzYm2AHAX6VOvgWWa5PmRFNxznbx9K9u0vwvFAysUy5Heujh8LiTlovlbsVBri+uTlselHBQW6Pna78Aun3Ixv9NvSltPhrPLJFF5RJ7YHY9a+mrHwNBNNveJeB6cV1GjfD2BZIn8vBJHbPSs3jaiVjT6nT3aPmJvhHc3wQeU5ZgRyudozkAV1N5+y3Ivh2y1GG2drjdh1UclT0I/GvrrQ/h/BdyJE0Hyc545NfTXgf4PWq+G1S8t1lhcY2lcfKMe2fWrpYmtUd0zKphqMFqfjN4o+C+qeE7jfqVrvtZ1zG68EE9Qf9rBz/wDqrzLWtHufD9wo3bww/wBavcEYx9MV+zvxg+COj3lpc6aU3rIgkimK4IYdB+GPyr4R+OfwMuPDaC7hsjJprLiWNQT5b5Y7uO1ejh8apS9nU3PLxGC5Y88Nj558D+MBpMiWsz3KW0g+dYZimc8YI+6fxGPWvXbXwv4X8R2sc1zZQkkcFtJUZz1Jeza3x9WDfjXg/iezex1AyxQ4iyQwXOMg8n2r0j4Ta0buzltphvKfMAEyAMd+Dj8q3xXNCPPBnz9SJ0Nz8CdC1JgumaiftDf8srK9imC/VLgW+36eaxrHf9n/AFqzYxrc3BA540bUJv8Ax62gmiP/AAGRq7xpmmG0AHjoSX/Qk/8AoNOjuJI1wkzxD+6jBR+QK/yrzo46qtznsX7T41WjMBc2Dpzj924P8wK2IPi54dkZVknlt2/24iR+a5r6R8bf8E4dF0+3muNK8UQXEO87fPt5Y5B3A3LK6fkgryHxN+wP4m0mxkuraW3m2r5gWK/SVmXk/daOPB/E16UqKXQxUdT5b/aI8YW2valbJZXKXFskeFK4/Htkfia4r4Y+Ef7X1KOWUYjznp156VofFTwle+G/Glzot/byW91bP5bxyLhvr1I5GOhI969L+F/hlrOzjnddoIGPf3rHFVPY0uVH0uAo88k7aI73TNMjs4ESGMKAO1X4bcbhuFT2kY288e9EepWjXHkqwZh1xXzfLKWp9Wmkammwqzg8Z6dK7bRdPLIZHTMfTBrmtNsGnkUxIGjxksDzn0xivRNJt1aCNO9XG8VsXoxtlpUe3IXaCa37WOOPYg/A0RWA2jnj2qRbPZIoBrO9yz0TwbKkc0DsFUg8swznivatP+IEq2awMkaxbcDYSSO3+eK8F021EdtHlyGPIrvfDlnH5aZCnB+bt27V0Qm4rRnPOClua3i+ZtSt45dx27t2OvtXnev6DaatZT2lzEskUilWVh1r0XVFijhKqvA61xepXCLISEbBYDCjPU4/KuOpdS5kaLVWZ+bX7RnwquPBWrXZtIwIWfcB1JUAjP4qT/3z7muK+A9qtx4mktJ4hJE8THO3oQOOa+y/2pfDMOu+G5pkXdcorFcdeOmPfk18z/BPQ/s/ii6J3ReTCRtAO1jnkn3r6WFX2uGuz4nMaXs3Kx6LL4JtpFGyWZMDkMQ2fzFVT4Jm/wCflQO2A4/k1dyIKPJrg5UzwOZn1hP4j1Dj/SmGOQqk8cUsHiW5vJXN5IZh5ZXDd/aq7aYx+tLHpDbWOQOO/Fe1zMuKZ+e37VGnjUf2ktRhWJUDtEh2jgkDaSD36dfXI7V0VvDHp9uqquFVcACnftZ6tpUfxe1DxrpySXmhWskcDSrtzPJI0+wICfu7YX54+705BOZpeqarq1xIq6KqWyEB5Zbsbg2Adu0KckAjocc9a4sXSnOSk9j67A1Ixjy9RyaLrniAvLvktLY/KsaMAcfXIyabN4JvtLXzLK1urhwMttdcn82FdzZXmqSIqDSYyij5T9oVR/Kj/hIPEVnG3m+FTKuM/wCh6nbyH8nMf865o9k0epeLRw2h/EjV/Cl0qXemXX2fO12lRhtH4Z/lXtvhz4haZq0EUsFwnzclW4IzXkGteOIpmZbvQNas1X7xeyEwHrzC0lU/D+vaRqF2Fsr+A3GeIC2yT/vhsN+lZzTfQ1g0up9NWOuRS5wcqO46VZXWYxKCSAO9ecaLNPHarkndis3XfEU1krgHDD1Ncjj2OhzSVz3qPxDDcBFV1UKAM7q6nQfido/h2TfdzxzoBgKHAH5np+tfCPiL4garHujk8R2umwscAvMqH9T/ACrnbS8t7icNL44E5Y/cjZ5OPT5W5reFLS7OOVe7sj9Hda+PHhjWrhLWzT7Px8zHBye/f9OKgkuI7qFZ4XWVG53KcjFfGPhfxZ4c0bBvNdZWAwJJkeMfmU/rXqXg/wCMXhjS7qFY/Gug/ZZPvw3WpxxZ57eYwINZ1MPzaouNa2jNX9oD/Q/D63BGY2co4+orw3wlNp2i6veLeT21nJJkxtLOoLDd0Gfz/GvfvjxNZa98JbrULG6t72zdlEV1byLLEzbhkB1yDjcM49a8F1D4D6742sbDUrVIBA8IIHmfPz7NgY/Hiu/DpRocstD5vNGpS0e53cEkVwm6J1kU/wASkEfpTvJFeQz/ALOvjbSJQ8Fhcp6G3zI5/wC/W7+dQt4K+JGnnyWXWY8chZJXU4+jEGrUI9z5xxP1D1b4d+INOiaRNGlvVHP+jSxM3/fJcH9K+ff2jPEmveHfBtk40jXPDgbVYI2uriF7cSLskO1XHcFQ3B/hr17T/ix4utY9ra28i/8ATWCFj+ZTNeV/tIa/qnjnwLFFf6jPei0vorkRFVCZw0edqgDIEh/WvRqyhyu256eAlSliYJ7XPhvxN4PvfFHizWdK1zVLnUbBGS/guJHDzoz5wvmkElRhvlJIAxXoHgeEQ2vn3eUbzJtxkXaDtkZA2PQhQfxqeTTEf7bciPa0sixo2eSqIAB+e7861dL017i1t2+WTaGikiBy6jOQxHod2M+3OOK8StWnNcreh9XDDwi20jP8ReKZre3Z9J2XD9ArAgfmR/SvLfFfj7xZpFrazRXTS+ZuW4gigk/dEYwdwJBByew6V7xb+FYIGDIuCxz6/hV+80kRxcMBgfdUYBrGg4R6GsqXMrJ2PnCx8Ya3rWpGaOH7XHLJgRxW7Ju4GTjHHOQB7V6Lf2Gkw2LJrtpa3tp5bAR3kKy7Swx8gIO1ueCvIPINdWumC1Z2WMFieMDmuW8VeDZPFFusayvb3KsVjk7bWBV+M8/KT9DitueMJJrQr2UlDl3E+DPwPl8WeG7a3fxT4i0u4JJkh027S2WF26x48vI29ME4zngVStvAreAfGHiaw1nWdU1mfTLhbe0N3cvllKKzNIAQHYMxQk8fL0Ga+gPhVoWuWGn21h4fhjnm3bmafLPK5OSzEc8/0o0n4Kp4+8ba/ruqwjS/JmlSeyiuXMj3RkdgWGMMm2V+eP8AUocHk1EcRKz5nuFTDxXKorY8Ij8ZQ+Fb+KcFYLy4PyR2sQV5OcZIUc/U1sw/tDeHtP1ZRcXLK8nzMrBnQNuIIJTdjkV6F8R/2fbOxmhmiVbhEHySspDpz2YYIrz7S/2WdN1XWkvPOuIGMm9l84MC2c5wynv71rzQcfe3Od0qkXeB6tp/xY0LxZar9jlijuY+G8qUfqOo/EV3vh++HiLS3tr22h1OyYbJbe6QSxyKeqsrAggjsax/Cv7HXgdlj1bWL/WLrUSdzzNexqD9AqcfnVyfS7TSbxvD3hmaZrcn99PcNvaNe43fSuLWMk0ymnbU+GPDPw/1PwL8UNc1i2sJLLwe+vXmgQXKSAeaGeSNY1TO90x8hYDH3hnNfon8O/CM9n4Q0mG8hWO4WEB1TGPY8cdMcdq8xuPhnY+HPD9nrGso32HTdYGox25JJyZZJWJ9Ms5Ptmuy0v4za1dafBcRWFvLcXii6HmKzbBIN6oFUjhQwX3xXoVKzrWR4GMwyp0vadb2PT7fwyuB8tXU8PBVAwR9K8nk8dfEvUPlsdOeMHkPa6S7D823CojY/Ge8/eiS/APTCQRf+O4FZbdTxjrVtCciuQ+JUHk+F9RZwdgVc/8AfQr23T9W0i1Yb/C9nKe/+kTc/wDfTNXOfGC88LXnw91tI9BbTL94QIJo7x3HmbgQNp45x6dzXpStyvUWD0xEH5o+LbT5tLsIi5kZV3M7Yy2T1OOK2LKwRWE4JDY4rKaNLG6SAEsiggE9etblvKqqoB4NeJN+8fpFPa5aju3VgN5JH97n+dXbe+W45McU207T14PocEVXghi4YjLE1duLyK1tcKoGB0UURkbWRja9rUFvCT5EMIH9wE/lkmsHR7y41BvtDxmI4wFwMqKXVYpLx/tcyH7PGd23p+P0rKvPH0dlJHbaXpF1qCYHmXMBiWJT6fM4J/AUO8jXlS2R9P8AwN1yHwvrem3dwyeQzBZs/NtQnGceo612msXjaJ8TbnUrF1k0zVxLbSbRlXbJeFsdM7hgf72K+TP+E2mtYTcef5AjXcS3QfgOtdt8Pf2htO8SWU1ld/aWnhH+ruraWI49V3gZ+ozisHdq3QjRyuexS+JtO8ZQlgyKckeWowPfqeKyLrSf7Nk86NCy4yMYxjOPSvKtF1gW/iTUWgbEDztIue2eSPzJrt7zxRcXVqIYZTtYYZeo/Cmm7akuK6FzWfiI5tPsFq0iSEbSFcY/lXVfDXwn/wAS57q+ILSneI/fsT6/yrgdA0NTeieddzt39K9Q0vWPIhEI+6vSsZy7GLgrkHxQ0D/hIvBt7pUTbZborFGw7OT8v64r1HwF4Rg8MeG9L0mAbks7WODd1LbVwT+ea5TS7VNcurSNuVjmSfr3Vg39K9i03ULm1hEUczpGBwo6DnNO7srHzmYzvJQ6FNNPXjipVs12itG41CVLeRpbiZo1UllLk5H0zUELpPGWXoGZefUEg/yoPGseVrZnd0rmPiR4PuvFfhmWyspFivFdZYhI21XIyCpODgEE/pXpP9mlW5WoJ7Ha2cV7+551GUqU1OO6PhDxp4a1Dwrr8dpqcMdvdPEsvlxSeYFByMbsdeOcce9JZq23HU9vSvUP2pdHez8TaHqfSK4tnt/oyNu/lJ+lea6flljYEAfxcckYryqy5ZaH6JhKrrUYzfU0oU8uEE8n0pJo/OwCMj0qU8sAOgFU766W3jLu/lqvJaudSPQIry4jhQq2COm2sCLRdN+1h1s44t3XHH6VzPiL4yeH9LkmtyXNynQSKVJ/MVycXxqt7iYM115Cg5AER2fQkjn8a7Y05SV0jSKcj2D/AIRsas0kdoisx+VVIro/hx8G4P7fgvdfuQttbtuWzjcjzT1w5/u+w615HD+0BZWUMQtNQ0uxmxhp4tgdjng89D9BXf8Ahn9oCx8SRxwX09ubtul5buAJP94DofcVlOMo6tGco8h6b420GximF/o8KxRpxJCnT6iuds9QEcw5IBq/omvQ6lcExXCTLnnDA5rQ1Lw5C03mQqF3c8GuSU7mTkb+h3iTW6AtlgOTjAJrQiunjuM9vauS0Wzns5juJC9vSuhW43PgHBNY7mXMeufDOPzbgztyq4X6E9K9lt7uUKijYFVcDEa5/PFeP/DjQdRY218t5HFprfft/KJeRlPBDZwB+Fetw8flXZskj5XGzjOreJLc263kEscn3ZFKsRweR2pILdLeMogOCzPz6sxJ/U1Jmk3Ck4nAaE3hG1bJSfn0IFZmoeDgLaeRJgfLQsfl6498/T86+L9G/wCCl3wm1FIE1bwj4w0W5cgObM2t5BH0/iaRHIHslereGf2qvgf40uIbXS/idp9ley/8sddtJ9ORSf4TNKgjz06NX01TDyv7uhzul2Iv2vPhy6fDOC/yHurGc3SheojA2yg+2GDf8Ar5E0XVFeMJkAiv0L1LTZPscT3ESXWn3CZjmVllgmRh1VgSpBH6V+fHxw8H/wDCofiNcaba7hpV0gu7FmycRMSPLJPUqQVyeSAD3ry8TRaSkfS5XiEl7B/I1zfJ/ewfr1qvct9q4ZQVHauK0zxELmQBnxz3rqorxZowF79a8jVM+mWpV1Lw7Z6lGWI8t1X5WTqK46azbSWYSBZlzkgjOfwr0hUzH/PFZt5oYubhSIzIWGAvauunUmtmbxk47HH6PqWmW1wGTQNMuicljPAshPHTay4xW3N4O8H+OLoNd+D9JspuvmabbizZT6gxbf1rqdD+E76lN92O3XIOeePyruLf4Uvpe3yplYr129frUzxFZdSKknLdHIeHfgzZ+EbVbvR9QvQVbebe5uDIMemTXd6ReCWMLI58xRjmpbPS7izzFK+6sPWg2mymVTx3rgbc3fqcU3ynVDYq4LA9+Kjs7gfaQAd3YLXDv4tKIMNg+tdR4T8C6z8QdB1CW3v/AOyIpEMEN4Yy7FjwxUAjp656110qDkzy8RiFTi5H1h4atU03SLO2Dt+7iUHgdcZJ/MmulhlX+8TxXGR+IYo/+WL4HpirsfjC1QcwTdOwX/GtPZVOx8u5p6s69Ajg4Yn/AIEaRbVMfek/7+N/jXNQ+OrGPOYLnnjhV/8AiqmXx9p5UfurkfVF/wDiq0VOfVC5kfhGy8g54OMYpzbkUH+H0p5wxXv3obBTax468f5/zivuWka2PV/2f/2qPHX7PmrRrod9/aPhqRwb3wzqLGSxuVJ+bav/ACykOTh0wc43BgNte/8A7Q/xS8MfHzT/AAb4p8LCa2jlsZ4rzS7ohptPuFkUtCxH3hg7lb+JSD1yB8RiFg68cc5r2j4O25/sK78wNlrlid/X7q14+YWjRbPUwEeauvImCyRcBtjrXQ6H4me1wk546BqsaloPmJuQYP0rEksZIVwwr5htS3Pp1eOx6PY69FcAMkgOe2a2U1JGUbdue1eP2czRtgMUatu21SeNeXLDpwaxaaKc2j1rR/FE9iVWSQspPXvXaQ+NYmhQedz2Oc18/wAer3MQBzuX0zxU7a9cbPu7Pq1Tyc3UylWZ7Prnja2tLbd5w3DkHPWvNtf8czatNiJSidMdc1y7TS3kmXYtXTeEPCcmuXqAqVizyfX2rtp04U9XqcFSc56I7n4O/Cmfx9K2panK8GjQPtKr9+duu0HsORk/gPUfUFlZ2+n2kVrbRLBbwqESNBgKB0ArD8F6TFoHhu0s4BtRQTj6mtzzK9aCVkfI4iblVkr7EuQKY0gPA615B+1l8dNW+BPw28OyeGLW1HiHxDeXUf8Aad7bpcraQ26xFgkUgKF2MyfMynAVuOQR8S+Iv2tPjB4oH+l/EjXrJAMeXo1wNLT/AL5tREP0rup4dySkZ+z6s/Tcw3DcpbyuP9mMn+lMMd2D/wAes3/fpv8ACvyjm+N/xDvk2XHxC8XXQHI+0a/dyAf99SGqDfFfxkzEnxhr5PcnVZ//AIutvqw/ZrucYrbV3A4/xoWYDO444/iNbngvS7bWI9fe7j80aVZi7iTcVEjGRV2vg524OeCDnvXvvhHw3pOg306WOmWsW1YSsjwrJIC24kh3y3G0YGccnivraGWSrx5+ZJDlW5eh4LoPg7VNe8l7aDy7WV9iXExKxuwGSBgEsAOpAIHGSMivaPB+gr4bsYrNZPOcfNJJ2Z++PbgAfSta7upr7xjqzTyvKLeCJIlY5CBmfdjPrsXP+6Kk0uMPctmvg84qcteWGjtF/efXZdRSpqs92bUMe+MA8k/pVe60lZMnb1/KtXYBDvAwQKkjw64I4r5xnsnGXWh7cuF4qJNLZsfPiuyvLVPLPWsWaMIxIzWdiWrlFbCUfKW4HSnrYnHzEmrcMhkXJq3ZQrNKFYZGaqJySWtifw34ck1C6VQvHc1734Q8NxaZBCI0w46nHA/+vXLeA9Lt2m2hdoVd3y9/rXqlmqxqqhQApAAqua7sNQ5Vc6+3zHbxJ/dUD9Kc0pqFmNN3E19FFaI/PJP3nc85/be8Av4o/ZJGtwQLJd+G9ajvmbHzC2kUQSge26SJz7R57V+XLSEkgHHNftD498P2fiPw74X0W+VpdO1bTdXsLuENgPFLFAjfiByD2IBr8U/PaSKGU4DPGrHHTJANevh3eFjt6IsiQr3p2aomQ7utToxK9a67Af/Z"
            // "picinfo"=>"data:image/jpg;base64,".$image
          ]);
        // return Response::json(['success' => $im,]);
        // return response()->file(public_path('itemimage/13.jpg'));
    }

    public function index(Request $request){
        $setings = DB::table('settings')->latest()->first();
        $category = DB::select('select * from categories where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $uom = DB::select('select * from uoms where ActiveStatus="Active" and IsDeleted=1 order by Name asc');
        $taxtypes = DB::select('select * from taxtype');
        $itemtypes = DB::select('SELECT * FROM item_types WHERE item_types.status="Active" ORDER BY item_types.type ASC');
        $supplier_data = DB::select('SELECT customers.id,CONCAT_WS(", ", NULLIF(customers.Code, ""), NULLIF(customers.Name, ""), NULLIF(customers.TinNumber, "")) AS customer FROM customers WHERE customers.CustomerCategory IN("Supplier","Customer&Supplier") AND customers.ActiveStatus="Active" ORDER BY customers.Name ASC');
        $lastsku = DB::table('regitems')->latest()->first();

        $item_properties = [
          'category' => $category,'uom' => $uom,'taxtypes' => $taxtypes,'supplier_data' => $supplier_data,
          'lastsku' => $lastsku,'setings' => $setings,'itemtypes' => $itemtypes
        ];

        if($request->ajax()) {
          return view('registry.item',$item_properties)->renderSections()['content'];
        }
        else{
          return view('registry.item',$item_properties);
        }
    }

    public function paginate($items, $perPage = 5, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function showItemData($type)
    {
      switch ($type) {
        case 'All':
              $item=DB::select('SELECT regitems.id,regitems.Type,regitems.Name,regitems.itemGroup,regitems.Code,regitems.MaxCost,regitems.averageCost,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.MinimumStock,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId=regitems.id) AS Balance,(SELECT IFNULL(SUM(salesitems.ConvertedQuantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.IsDeleted=1 ORDER BY id ASC');
          break;
        case 'Goods':
            $item=DB::select('SELECT regitems.id,regitems.Type,regitems.Name,regitems.itemGroup,regitems.Code,regitems.MaxCost,regitems.averageCost,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.MinimumStock,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId=regitems.id) AS Balance,(SELECT IFNULL(SUM(salesitems.ConvertedQuantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.IsDeleted=1 and regitems.Type="Goods" ORDER BY id ASC');
          break;
        case 'fixedasset':
            $item=DB::select('SELECT regitems.id,regitems.Type,regitems.Name,regitems.itemGroup,regitems.Code,regitems.MaxCost,regitems.averageCost,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.MinimumStock,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId=regitems.id) AS Balance,(SELECT IFNULL(SUM(salesitems.ConvertedQuantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.IsDeleted=1 and regitems.Type="Fixed Asset" ORDER BY id ASC');
        break;
        case 'service':
          $item=DB::select('SELECT regitems.id,regitems.Type,regitems.Name,regitems.itemGroup,regitems.Code,regitems.MaxCost,regitems.averageCost,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.MinimumStock,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId=regitems.id) AS Balance,(SELECT IFNULL(SUM(salesitems.ConvertedQuantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.IsDeleted=1 and regitems.Type="Service" ORDER BY id ASC');
        break;
        default:
              $item=DB::select('SELECT regitems.id,regitems.Type,regitems.Name,regitems.itemGroup,regitems.Code,regitems.MaxCost,regitems.averageCost,uoms.Name as UOM,categories.Name as Category,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.Description,regitems.SKUNumber,regitems.BarcodeType,regitems.ActiveStatus,regitems.MinimumStock,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId=regitems.id) AS Balance,(SELECT IFNULL(SUM(salesitems.ConvertedQuantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems INNER JOIN categories on regitems.CategoryId=categories.id INNER JOIN uoms on regitems.MeasurementId=uoms.id where regitems.IsDeleted=1 and regitems.Type="Consumption" ORDER BY id ASC');
          break;
      }
        return datatables()->of($item)->addIndexColumn()->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // $items=Regitem::whereIn('id',[2133,2132])->with('category')->get(['id','Name']);
      $items=Regitem::join('categories','categories.id','=','regitems.CategoryId')
                      ->join('uoms','uoms.id','=','regitems.MeasurementId')
                      ->whereIn('regitems.id',[2133,2132])
                      ->get(['regitems.itemGroup','regitems.Code','regitems.Name','regitems.SKUNumber','categories.Name as category','uoms.Name as UOM','regitems.RetailerPrice','regitems.WholesellerPrice']);
      //$category=Category::with('items')->get();
      return Response::json(['success' => $items,]);
    }
    public function printbarcodes($id)
    {
      $bacode=Regitem::find($id);
      $data=['bacode'=>$bacode];
      $pdf=PDF::loadView('registry.invoice',$data);
      return view('registry.invoice',['bacode'=>$bacode]);
    }
    public function printbar()
    {
      return view('registry.barcode');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function batchupdate(Request $request){
      
        $validator = Validator::make($request->all(), [
          'category'=>'required',
          'itemGroup' =>'required',
          'percent'=>'required|integer|gt:0',
          'item'=>'required',
          'increaseDescrease'=>'required'
        
            ]);

            if ($validator->passes()) {
              $groups = implode(", ", $request->item);
              $itemid = array_map('intval', explode(',', $groups));
            
              $items=Regitem::whereIn('CategoryId',$request->category)->whereIn('itemGroup',$request->itemGroup)->whereIn('id',$itemid)->get(['id','MaxCost','RetailerPrice','WholesellerPrice']);
              
              if($request->increaseDescrease==1){
                foreach($items as $item){
                  $itemlog=new Itemlog();
                  $itemss=Regitem::find($item['id']);
                  $group=$item['itemGroup'];
                  // $newprice=($request->percent*$item['RetailerPrice'])/100;
                  // $newsprice=($request->percent*$item['WholesellerPrice'])/100;
                  $newprice=($request->percent/100)+1;
                  
                  $updateprice=round($newprice*$item['RetailerPrice'],2);
                  
                  $updatewsprice=round($newprice*$item['WholesellerPrice'],2);
                
                  Regitem::where('id',$item['id'])->update(['RetailerPrice'=>$updateprice,'WholesellerPrice'=>$updatewsprice]);
                  $itemlog->retailprice=$item['RetailerPrice'];
                  $itemlog->wholesaleprice=$item['WholesellerPrice'];
                  $itemlog->newretailprice=$updateprice;
                  $itemlog->newwholesaleprice=$updatewsprice;
                  $itemlog->type=1;
                  $itemlog->percent=$request->percent;
                  $itemlog->changedby=auth()->user()->username;
                  $itemss->additemlog()->save($itemlog);


                }
                return Response::json(['success' => "increased",]);

              }
              else if($request->increaseDescrease==2){
                $itemunchanged=[];

                foreach($items as $item){
                  $itemlog=new Itemlog();
                  $itemss=Regitem::find($item['id']);
                    $group=$item['itemGroup'];
                    $newprice=($request->percent/100)+1;
                  // $newprice=($request->percent*$item['RetailerPrice'])/100;
                  // $newsprice=($request->percent*$item['WholesellerPrice'])/100;
                    $updateprice=round($item['RetailerPrice']/$newprice,2);
                    $updatewsprice=round($item['WholesellerPrice']/$newprice,2);
                  if($updateprice>$item['MaxCost']){
                  
                  Regitem::where('id',$item['id'])->update(['RetailerPrice'=>$updateprice,'WholesellerPrice'=>$updatewsprice]);
                  $itemlog->retailprice=$item['RetailerPrice'];
                  $itemlog->wholesaleprice=$item['WholesellerPrice'];
                  $itemlog->newretailprice=$updateprice;
                  $itemlog->newwholesaleprice=$updatewsprice;
                  $itemlog->type=2;
                  $itemlog->percent=$request->percent;
                  $itemlog->changedby=auth()->user()->username;
                  $itemss->additemlog()->save($itemlog);

                  }
                  else if($updateprice<=$item['MaxCost']){
                    $itemunchanged[]=$item['id'];
                  
                  }
                
                }
                $length=count($itemunchanged);
                if($length>=1){
                  $unchageditems=Regitem::whereIn('id',$itemunchanged)->get(['id','Name','Code','SKUNumber']);
                }
                else if($length==0){
                  $unchageditems=0;
                }
                return Response::json(['success' => "decreased",'itemunchanged'=>$unchageditems,'length'=>$length]);
              }

              
            }

            if($validator->fails())
          {
              return Response::json(['errors' => $validator->errors()]);
          }


    
    }
    public function getbatchitemlog(Request $request){
      $validator = Validator::make($request->all(), [
        
        'itemGroup' =>'required',
        'category'=>'required',
      
          ]);
      
          if ($validator->passes()) {

            $groups = implode(", ", $request->category);
            $category = array_map('intval', explode(',', $groups));
            $items = Itemlog::join('regitems','regitems.id','=','itemlogs.regitem_id')
                              ->whereIn('regitems.itemGroup',$request->itemGroup)
                              ->whereIn('regitems.CategoryId',$category)
                              ->distinct()
                              ->get(['regitems.id','regitems.Code','regitems.Name','regitems.SKUNumber']);
            return Response::json(['items' => $items]);
          }
          if($validator->fails())
          {
              return Response::json(['errors' => $validator->errors()]);
          }

      
    }
    public function getbatchitem(Request $request){
      $validator = Validator::make($request->all(), [
        
        'itemGroup' =>'required',
        'category'=>'required',
      
          ]);
      
          if ($validator->passes()) {
            $groups = implode(", ", $request->category);
            $category = array_map('intval', explode(',', $groups));
            $items=Regitem::whereIn('itemGroup',$request->itemGroup)->whereIn('CategoryId',$category)->whereNotNull('RetailerPrice')->whereNotNull('WholesellerPrice')->get(['id','Name','Code','SKUNumber']);
            
            return Response::json(['items' => $items]);
          }
          if($validator->fails())
          {
              return Response::json(['errors' => $validator->errors()]);
          }

      
    }
    public function batchupdatepreview($item){
      $items = array_map('intval', explode(',', $item));
      //$items=Regitem::whereIn('id',$request->item)->get(['itemGroup','Code','Name']);
      $item=Regitem::join('categories','categories.id','=','regitems.CategoryId')
                      ->join('uoms','uoms.id','=','regitems.MeasurementId')
                      ->whereIn('regitems.id',$items)
                      ->orderBy('regitems.id','DESC')
                      ->get(['regitems.itemGroup','regitems.Code','regitems.Name','regitems.SKUNumber','regitems.MaxCost','categories.Name as category','uoms.Name as UOM','regitems.RetailerPrice','regitems.WholesellerPrice','regitems.MaxCost','regitems.id']);
                    return datatables()->of($item)->addIndexColumn()->toJson();
      // return Response::json(['errors' => $items]);
    }
    public function pricehangelog(){
      $category=Category::where('ActiveStatus','Active')->where('IsDeleted',1)->orderBy('Name','Asc')->get(['id','Name']);
      $items=Itemlog::join('regitems','regitems.id','=','itemlogs.regitem_id')
                          ->orderBy('itemlogs.created_at','DESC')
                        ->get(['itemlogs.id','regitems.Name','regitems.Code','regitems.SKUNumber']);
                        $compInfo=companyinfo::find(1);
                        $companyname=$compInfo->Name;
                        $companytin=$compInfo->TIN;
                        $companyvat=$compInfo->VATReg;
                        $companyphone=$compInfo->Phone;
                        $companyoffphone=$compInfo->OfficePhone;
                        $companyemail=$compInfo->Email;
                        $companyaddress=$compInfo->Address;
                        $companywebsite=$compInfo->Website;
                        $companycountry=$compInfo->Country;
                        $companyLogo=$compInfo->companyLogo;
                        $companyalladdress=$compInfo->AllAddress;

      return view('report.pricechangelog',[
        'category'=>$category,
        'companyname'=>$companyname,
        'companytin'=>$companytin,
        'companyvat'=>$companyvat,
        'companyphone'=>$companyphone,
        'companyoffphone'=>$companyoffphone,
        'companyemail'=>$companyemail,
        'companyaddress'=>$companyaddress,
        'companywebsite'=>$companywebsite,
        'companycountry'=>$companycountry,
        'companyalladdress'=>$companyalladdress,
    ]);
    }
    public function getpricelog( $from,$to,$group,$type){
      $categories=$_POST['category'];
      $items=$_POST['item'];
      // $categories=implode(',', $category);
      // $items=implode(',', $item);
      // $categories = array_map('intval', explode(',', $category));
      // $items=array_map('intval', explode(',', $item));
      $groups=explode(",",$group);
      $types=array_map('intval', explode(',', $type));
      $itemlog=Itemlog::join('regitems','regitems.id','=','itemlogs.regitem_id')->join('categories','regitems.CategoryId','=','categories.id')->whereIn('regitems.itemGroup',$groups)
                        ->whereIn('regitems.CategoryId',$categories)->whereIn('itemlogs.regitem_id',$items)->whereIn('itemlogs.type',$types)->whereDate('itemlogs.created_at','>=',$from)
                        ->whereDate('itemlogs.created_at','<=',$to)->orderBy('itemlogs.created_at','DESC')->get(['regitems.itemGroup','regitems.Code','regitems.Name','categories.Name AS CatergoryName','regitems.SKUNumber','regitems.MaxCost','itemlogs.retailprice','itemlogs.wholesaleprice','itemlogs.newretailprice','itemlogs.newwholesaleprice','itemlogs.type as incrdcr','itemlogs.percent','itemlogs.changedby','itemlogs.created_at']);
                        return datatables()->of($itemlog)->addIndexColumn()->toJson();
      // return Response::json(['items' => $group]);
    }
    public function upload(Request $request){
        $image = $request->file('file');
        $imageid = $request->itemsid;
      //   $imageName = $imageid . '-' . time() . '.' . $image->extension();
      //   $path='itemimage/'.$imageName;
      //   $input['imagename'] = $imageid.$image->getClientOriginalName();
      //   $filePath = public_path('/itemimage');
      //   $img = Image::make($image->path());
      //   $img->resize(350, 250, function ($const) {
      //   $const->aspectRatio();
      // })->save($filePath.'/'.$input['imagename']);

        $imageName = $image->getClientOriginalName();
        $filePath = public_path('/itemimage');
        $image->move(public_path('itemimage'),$imageName);
        $itemimg = itemimage::updateOrCreate(['imagename' => $imageName,'regitem_id'=>$request->regitemsid],
        [
          'imagename' =>$imageName,
          'regitem_id' =>$request->regitemsid,
          'imagepath' => $filePath
        ]);
        return response()->json(['success' =>$imageName]);
    }
      public function fetch($id){
            $images='';
            $success=0;
            $exist= $images=itemimage::where('regitem_id',$id)->exists();
            switch ($exist) {
              case True:
                $images= $images=itemimage::where('regitem_id',$id)->orderBy('id','DESC')->get();
                $success=1;
                break;
              default:
              $success=0;
                break;
            }
          return Response::json([
                      'success' => $success,
                      'images'=>$images,
                        ]);
        }
    public function store(Request $request){
      $number=null;
      $barcodename=null;
      $itempathstore=null;
      $ty=null;
      $oldsknumber=null;
      $oldbarcodetype=null;
      $profitmarginretail=null;
      $profitmarginwholesale=null;
      $message='';
            $type=$request->TypeId;
            if($type=='Goods'||$type=='Consumption')
            {
              $ty='Goods';
              $validator = Validator::make($request->all(), [
              'TypeId'=>"required",
              'group'=>'required',
              'item_image' => 'image|mimes:jpeg,png,jpg,gif,svg',
              'code'=>"required|max:255|min:2|unique:regitems,Code,$request->id",
              'Category'=>"required",
              'Uom'=>"required",
              'wholeSellerPrice'=>'nullable|numeric|lt:retailPrice',
                ]);
                $validator->sometimes('name', "required|min:2|max:255|unique:regitems,Name,$request->id", function ($input) {
                  return $input->id!=null;
                });
                $validator->sometimes('name', "required|min:2|max:255|unique_space_check:regitems", function ($input) {
                  return $input->id==null;
                });
                $validator->sometimes('retailPrice', 'required|gt:0', function ($input) {
                return $input->wholeSellerPrice > 0;
                });
                $validator->sometimes('wholeSellerMinAmount', 'required|gt:0', function ($input) {
                  return $input->wholeSellerPrice > 0;
                  });
              $validator->sometimes('skuNumber', "required|unique:regitems,SKUNumber,$request->id", function ($input) {
                return ($input->TypeId == "Goods" &&  $input->barcoderequire =="Require");
              });
            }
            if($type=='Service')
            {
              $validator = Validator::make($request->all(), [
              'TypeId'=>"required",              
              'name' =>"required|max:255|min:2|unique:regitems,Name,$request->id",
              'code'=>"required|max:255|min:2|unique:regitems,Code,$request->id",
              'Category'=>"required",
              'Uom'=>"required",
                ]);
            }
            
              if ($validator->passes()) {
                $item=new Regitem;
                $number=$request->skuNumber;
                if(!empty($number)){
                    $barcodelenth=Str::length($number);
                    
                    if($barcodelenth==12 || $barcodelenth==13){
                        include(app_path().'/CustomClass/barcode.php');
                        $barcode_images = new Barcode($number, 4);
                        $barcode_image=$barcode_images->image();
                        $barcode=Image::make($barcode_image);
                        Response::make($barcode->encode('jpeg'));
                        $savename = $number.'.'.'png';
                        $barcodepath = public_path() . '/barcode/'.$savename;
                        $barcodename="barcode/".$savename;
                        file_put_contents($barcodepath,$barcode);
                    }
                  } else{
                      $number=null;
                      $barcodename=null;
                  }
                  
                  switch ($request->TypeId) {
                    case 'Service':
                      $barcode=null;
                      break;
                    
                    default:
                        if($request->BarcodeTypes=='Generate'){
                            if($request->id==null){
                              $num=$request->skupdate;
                              $num+=1;
                              $updn=DB::select('UPDATE settings SET skunumber=skunumber+1 WHERE 1');
                            } 
                            else{ // on edit generate barcode if it is not generated before
                              if($request->BarcodeTypesupdate==null){ 
                                  switch ($request->BarcodeTypes) {
                                    case 'Generate':
                                      $updn=DB::select('UPDATE settings SET skunumber=skunumber+1 WHERE 1');
                                      break;
                                    
                                    default:
                                      # code...
                                      break;
                                  }
                              }
                            }
                        }
                        if($request->id==null){
                          $oldsknumber=$number;
                          $oldbarcodetype=$request->BarcodeTypes;
                        }
                        else if($request->id!=null){
                          $oldsknumber=$request->skuNumberupdate;
                          if($request->BarcodeTypes=='Generate')
                          {
                            $oldbarcodetype="Generate";
                            
                            $oldsknumber=$number;
                          }
                          else{
                            $oldbarcodetype=$request->BarcodeTypesupdate;
                            $oldsknumber=$request->skuNumberupdate;
                          }
                          
                          if($request->pmretail=="AD"){
                            $profitmarginretail=$request->pmretailhidden;
                          } else{
                            $profitmarginretail=$request->pmretail;
                            
                          }
                          if($request->pmwholesale=="AD"){
                            $profitmarginwholesale=$request->pmwholesalehidden;
                          }else{
                            $profitmarginwholesale=$request->pmwholesale;
                          }
                        }
                      break;
                  }
                
                  
                  
                try
                {
                  $sale=Regitem::updateOrCreate(['id' =>$request->id], [
                    'Name' => trim($request->name),
                    'Code' => trim($request->code),
                    'MeasurementId' =>trim($request->Uom),
                    'CategoryId' => trim($request->Category),
                    'RetailerPrice' => $request->retailPrice,
                    'WholesellerPrice' => $request->wholeSellerPrice,
                    'wholeSellerMinAmount' => $request->wholeSellerMinAmount,
                    'wholeSellerMaxAmount' => $request->wholeSellerMaxAmount,
                    'MinimumStock' => $request->minimumstock,
                    'pmretail'=>$profitmarginretail,
                    'pmwholesale'=>$profitmarginwholesale,
                    'RequireSerialNumber' => trim($request->ReqSerialNumber),
                    'TaxTypeId' => trim($request->TaxType),
                    'RequireExpireDate' => trim($request->ReqExpireDate),
                    'PartNumber' => trim($request->partNumber),
                    'Description' => trim($request->description),
                    'BarcodeType' => trim($request->BarcodeTypes),
                    'oldBarcodeType' => trim($oldbarcodetype),
                    'ActiveStatus' => trim($request->status),
                    'Type' => trim($request->TypeId),
                    'itemGroup' => trim($request->group),
                    'LowStock' => trim($request->lowStock),
                    'IsDeleted' => '1',
                    'path' => $itempathstore,
                    'imageName' => $barcodename,
                    'SKUNumber' => $number,
                    'oldSKUNumber' => $oldsknumber,
                    'standard_factor' => $request->factor
                    
                    ]);
                    $late=Regitem::where('SKUNumber',$number)->get('id');
                    $updateretail=Regitem::whereNull('RetailerPrice')->update(['RetailerPrice'=>0]);
                    $updatewholesale=Regitem::whereNull('WholesellerPrice')->update(['WholesellerPrice'=>0]);
                    $updatewholesalemin=Regitem::whereNull('wholeSellerMinAmount')->update(['wholeSellerMinAmount'=>0]);
                    $updatewholesalemax=Regitem::whereNull('wholeSellerMaxAmount')->update(['wholeSellerMaxAmount'=>0]);
                    $updateminstock=Regitem::whereNull('MinimumStock')->update(['MinimumStock'=>0]);
                    if($request->id!=null)
                    {
                      $itemlog=new Itemlog();
                      $itemss=Regitem::find($request->id);
                       // hidden values
                      $updatemaxcost=$request->notifiablemaxcostid;
                      $updateretailprice=$request->notifiablereailerpriceid;
                      $updatewholesellprice=$request->notifiablewholesellerpriceid;
                      // original content
                      $maxost=$request->maxcost;
                      $retailprice=$request->retailPrice;
                      $wholesaleprice=$request->wholeSellerPrice;
                      $itemcode=trim($request->code);
                        if($updatemaxcost!=$maxost)
                        {
                          //$users2= User::Permission(['Max-cost'])->get();
                          $url='/items';
                          $itemname=$request->name;
                          $username=Auth()->user()->username;
                          $messages='MaxCost Updated from '.$updatemaxcost.' to '.$maxost.' for '.$itemname.'('.$itemcode.') item';
                              try {
                           // Notification::send($users2, new itemNotification($username,$messages,$url));
                            //auth()->user()->notify(new itemNotification($username,$messages,$url));
                          } catch(\Exception $e){
                          }
                        }
                        if($updateretailprice!=$retailprice)
                        {
                          if($retailprice>$updateretailprice){
                            $type=1;
                          }
                          if($retailprice<$updateretailprice){
                            $type=2;
                          } 
                          $itemlog->retailprice=$updateretailprice;
                          $itemlog->wholesaleprice=$wholesaleprice;
                          $itemlog->newretailprice=$retailprice;
                          $itemlog->type=$type;
                          $itemlog->changedby=auth()->user()->FullName;
                          $itemss->additemlog()->save($itemlog);
                          $users2= User::Permission(['Item-View'])->get();
                          $url='/items';
                          $itemname=$request->name;
                          $username=Auth()->user()->FullName;
                          $messages='Retail Price Updated from '.$updateretailprice.' to '.$retailprice.' for '.$itemname.'('.$itemcode.') item';
                              try {
                            //Notification::send($users2, new itemNotification($username,$messages,$url));
                            } catch(\Exception $e){
                          }
                        }
                        if($updatewholesellprice!=$wholesaleprice)
                        {
                            if($wholesaleprice>$updatewholesellprice){
                              $type=1;
                            }
                            if($wholesaleprice<$updatewholesellprice){
                              $type=2;
                            }
                          $itemlog->retailprice=$updateretailprice;  
                          $itemlog->wholesaleprice=$updatewholesellprice;
                          $itemlog->newwholesaleprice=$wholesaleprice;
                          $itemlog->type=$type;
                          $itemlog->changedby=auth()->user()->FullName;
                          $itemss->additemlog()->save($itemlog);
                          $users2= User::Permission(['Item-View'])->get();
                          $url='/items';
                          $itemname=$request->name;
                          $username=Auth()->user()->FullName;
                          $messages='Wholesale Price Updated from '.$updatewholesellprice.' to '.$wholesaleprice.' for '.$itemname.'('.$itemcode.') item';
                              try {
                          //Notification::send($users2, new itemNotification($username,$messages,$url));
                            } catch(\Exception $e){
                          }
                        }
                    }
                    else{
                      //
                      $itemcodetype=setting::where('id',1)->first()->ItemCodeType;
                      $itemcodenumber=setting::where('id',1)->first()->ItemCodeNumber;
                      $inc=$itemcodenumber+1;
                      if($itemcodetype==1){
                        $settingUpdate=setting::where('id',1)->update(['ItemCodeNumber'=>$inc]);
                      }
                    }
                    return Response::json([
                    'success' => '1',
                    'latest'=>$late,
                      ]);
                }
                catch(Exception $e)
                {
                  return Response::json(['dberrors' =>  $e->getMessage()]);
                }
            }
            return Response::json(['errors' => $validator->errors()]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function geteset()
    {
      return "ok geseted";
    }
    public function getitemcodes(){
      $setings=setting::where('id',1)->get(['ItemCodePrefix','ItemCodeNumber','BarcodeRequire','ItemCodeType','wholesalefeature']);
      foreach($setings as $seting){
      $itemprefix=$seting->ItemCodePrefix;
      $itemcodenumber=$seting->ItemCodeNumber;
      }
      $docPrefix=$itemprefix;
      $docNum=$itemcodenumber;
      $numberPadding=sprintf("%06d", $docNum);
      $docNumber=$docPrefix.$numberPadding;

      return Response::json(['setings' =>$setings,'docNumber'=>$docNumber]);
    }
    public function show($id)
    {
        $item=DB::select('SELECT regitems.id,standard_factor,regitems.Name,regitems.Code,uoms.Name as uom_name,categories.Name as category_name,regitems.MeasurementId,regitems.CategoryId,regitems.RetailerPrice,regitems.WholesellerPrice,regitems.wholeSellerMinAmount,regitems.pmretail,regitems.pmwholesale,regitems.wholeSellerMaxAmount,regitems.MinimumStock,regitems.TaxTypeId,regitems.RequireSerialNumber,regitems.RequireExpireDate,regitems.PartNumber,regitems.path,regitems.imageName,regitems.LowStock,regitems.itemGroup,regitems.Description,regitems.SKUNumber,regitems.oldSKUNumber,regitems.BarcodeType,regitems.oldBarcodeType,regitems.Type,regitems.ActiveStatus,regitems.MaxCost,regitems.minCost,regitems.averageCost,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId='.$id.') AS AvailableQuantity,(SELECT IFNULL(SUM(salesitems.Quantity),0) FROM salesitems WHERE salesitems.ItemId=regitems.id AND salesitems.HeaderId IN(SELECT sales.id FROM sales WHERE sales.Status IN("pending..","Checked"))) AS PendingQuantity FROM regitems LEFT JOIN categories on regitems.CategoryId=categories.id LEFT JOIN uoms on regitems.MeasurementId=uoms.id WHERE regitems.id='.$id);
        $exist= $images=itemimage::where('regitem_id',$id)->exists();
            switch ($exist) {
              case True:
                $itemimage=itemimage::where('regitem_id',$id)->orderby('id','DESC')->get(['imagename']);
                $success=1;
                break;
              
              default:
              $success=0;
              $itemimage='';
                break;
            }
        return Response::json([
        'success'=>$success,
        'item'=>$item,
        'itemimage' => $itemimage,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
      $item=DB::select('SELECT id,Name,standard_factor,Code,MeasurementId,CategoryId, RetailerPrice,WholesellerPrice,wholeSellerMinAmount,pmretail,pmwholesale,wholeSellerMaxAmount,MinimumStock,TaxTypeId,RequireSerialNumber,RequireExpireDate,PartNumber,path,imageName,LowStock,itemGroup,Description,SKUNumber,oldSKUNumber,BarcodeType,oldBarcodeType,Type,ActiveStatus,MaxCost,minCost,averageCost,(SELECT (sum(COALESCE(StockIn,0))-sum(COALESCE(StockOut,0))) AS Balance from transactions where transactions.FiscalYear=(SELECT settings.FiscalYear FROM settings) and transactions.StoreId in(select id from stores where stores.ActiveStatus="Active") and transactions.ItemId='.$id.') AS AvailableQuantity FROM regitems WHERE id='.$id);
      $transaction=transaction::where('ItemId',$id)->count();
      
      return Response::json([
        'transaction'=>$transaction,
        'item' => $item,
        
      ]);
      //return response()->json($item);
    }
    public function getsknumber()
    {
        $setings=DB::table('settings')->latest()->first();
        $numberPadding=sprintf("%05d", $setings->skunumber);
        $sknumber=$setings->prefix.$numberPadding;
        $sklength=strlen($sknumber);
            if($sklength==12 || $sklength==13){
              include(app_path().'/CustomClass/barcode.php');
              $barcode_images = new Barcode($sknumber, 4);
              $sk=$barcode_images->checksum($sknumber);
              return Response::json([
              'success' => 200,
              'setting'=>$setings,
              'numberpaddging'=>$numberPadding,
              'padded'=>$sk,
              'number'=>$sklength,
            ]);
            }
            else if($sklength<12){
              {
                return Response::json(['minierror' => "The sku number must be at least 12 characters."]);
            }
            }
            else if($sklength>13){
              return Response::json(['maxerror' => "The sku number must be at most 13 characters."]);
            }
            else{
              return Response::json(['systemerror' => "Please contact your support team"]);
            }
          
    }
    public function getgeneratebarcode()
    {
                  $setings=DB::table('settings')->latest()->first();
                  $numberPadding=sprintf("%05d", $setings->skunumber);
                  $sknumber=$setings->prefix.$numberPadding;
                  include(app_path().'/CustomClass/barcode.php');
                  $barcode_images = new Barcode($sknumber, 4);
                  $barcode_image=$barcode_images->image();
                  $barcodegen=Image::make($barcode_image);
                  $responsegen=Response::make($barcodegen->encode('jpeg'));
                  $responsegen->header('Content-Type', 'image/jpeg');
                  $setings=DB::table('settings')->latest()->first();
                  return response()->json([
                    'generated_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($barcodegen)).'"  />',
                    'setting'=>$setings,
                  ]);
    }

    public function getoldsknumber($sknumber){
                
                  include(app_path().'/CustomClass/barcode.php');
                  $barcode_images = new Barcode($sknumber, 4);
                  $barcode_image=$barcode_images->image();
                  $barcodegen=Image::make($barcode_image);
                  $responsegen=Response::make($barcodegen->encode('jpeg'));
                  $responsegen->header('Content-Type', 'image/jpeg');
                  $setings=DB::table('settings')->latest()->first();
                  return response()->json([
                    'generated_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($barcodegen)).'"  />',
                    'setting'=>$setings,
                  ]);
    }

public function getbarcode($id)
{
$item=Regitem::findOrFail($id);
if($item==NUll)
{
  return 'no selectes item';
}
else
{
  if($item->BarcodeImage!=null)
  {

    $barcode_file = Image::make($item->BarcodeImage);
    $responsebar = Response::make($barcode_file->encode('jpeg'));

    $responsebar->header('Content-Type', 'image/jpeg');

    return response()->json([

      'uploaded_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($item->BarcodeImage)).'"  />',

      ]);
  }
  else
  {
    return response()->json([
      'uploaded_barcodeimage'   => 'Barcode Not Found',
    ]);

  }
}

}

    public function getimage($id)
    {
      $item=Regitem::findOrFail($id);
      if($item==NULL)
      {
        return "def";
      }
      else{
        if($item->itemImage!=null)
        {
          $image_file = Image::make($item->itemImage);
          $response = Response::make($image_file->encode('jpeg'));
          session(["item_image_file"=>$image_file]);
          $response->header('Content-Type', 'image/jpeg');
          return response()->json([
            'message'   => 'Image Upload Successfully',
            'uploaded_image' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($item->itemImage)).'"  />',
           // 'uploaded_barcodeimage' => '<img class="card-img-top" src="data:image/jpg;base64,'.chunk_split(base64_encode($item->BarcodeImage)).'"  />',
            'class_name'  => 'alert-success'
          ]);

        }
        else
        {
            session(["item_image_file"=>null]);
          return response()->json([
            'uploaded_image'   => 'Image Not Found',

          ]);

        }
      }



    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->get('name')) {
            \File::delete(public_path('itemimage/' . $request->get('name')));
        }
          $images=itemimage::where('id',$request->get('name'))->delete();
          return Response::json(['success' => 'Image is successfully removed',
          ]);
    }
    

    public function delete($id)
    {
      try{
        $item = Regitem::FindorFail($id);
        $salecount = Salesitem::where('ItemId', $id)->count();
        $recievecount = receivingdetail::where('ItemId', $id)->count();
        $beginingcount = beginingdetail::where('ItemId', $id)->count();
        
        if($salecount==0 && $recievecount==0 && $beginingcount==0){
          $item->delete();
          return Response::json(['success' => 'Item Record Deleted success fully','salecount'=>$salecount,'recievecount'=>$recievecount,'beginingcount'=>$beginingcount]);
        }
        else{
          return Response::json(['errors' => 'Impossible to delete this items','salecount'=>$salecount,'recievecount'=>$recievecount,'beginingcount'=>$beginingcount]);
        }

        
      }
      catch(Exception $e)
      {
        return Response::json(['deleteErrors' => $e->getMessage()]);
      }
    }


                  public  function ean_checkdigit($code){
                  //  $font = "FreeSansBold.ttf";
                    $code = str_pad($code, 12, "0", STR_PAD_LEFT);
                    $sum = 0;
                    for($i=(strlen($code)-1);$i>=0;$i--){
                      $sum += (($i % 2) * 2 + 1 ) * $code[$i];
                    }
                    //$bn=(10 - ($sum % 10));
                    //echo $bn;
                    return (10 - ($sum % 10));
                  }


                  public  function encode_ean13($ean){

                    //$font = "FreeSansBold.ttf";
                    //$font_loc=dirname(__FILE__)."/"."FreeSansBold.ttf";
                    $font = public_path("app-assets/fonts/FreeSansBold.ttf");

                    $digits=array(3211,2221,2122,1411,1132,1231,1114,1312,1213,3112);
                    $mirror=array("000000","001011","001101","001110","010011","011001","011100","010101","010110","011010");
                    $guards=array("9a1a","1a1a1","a1a");

                    $ean=trim($ean);
                    if (preg_match("#[^0-9]#i",$ean)){
                      //die("Invalid EAN-Code");
                      return Response::json(['sknumberInvalid' => 'Invalid EAN-Code']);
                    }

                    if (strlen($ean)<12 || strlen($ean)>13){
                      // die("Invalid EAN13 Code (must have 12/13 numbers)");
                      return Response::json(['sknumberError' => 'Invalid EAN13 Code must have 12/13 numbers']);
                    }

                    $ean=substr($ean,0,12);
                    $eansum=$this->ean_checkdigit($ean);
                    $ean.=$eansum;
                    $line=$guards[0];
                    for ($i=1;$i<13;$i++){
                      $str=$digits[$ean[$i]];
                      if ($i<7 && $mirror[$ean[0]][$i-1]==1) $line.=strrev($str); else $line.=$str;
                      if ($i==6) $line.=$guards[1];
                    }
                    $line.=$guards[2];

                    /* create text */
                    $pos=0;
                    $text="";
                    for ($a=0;$a<13;$a++){
                      if ($a>0) $text.=" ";
                      $text.="$pos:12:{$ean[$a]}";
                      if ($a==0) $pos+=12;
                      else if ($a==6) $pos+=12;
                      else $pos+=7;
                    }

                    $datas=["bars" => $line,	"text" => $text];
                      return $datas;
                  }

                  public  function ean13_barcode($code, $scale = 1, $height = 0)
                  {
                    //$font = "FreeSansBold.ttf";
                    $font = public_path("app-assets/fonts/FreeSansBold.ttf");

                    $ean=$this->encode_ean13($code);

                    //foreach($ean as $ean)

                      $bars=$ean['bars'];
                      $text=$ean['text'];
                    $bar_color=Array(0,0,0);
                    $bg_color=Array(255,255,255);
                    $text_color=Array(0,0,0);

                    /* set defaults */
                    if ($scale<1) $scale=2;
                    $height=(int)($height);
                    if ($height<1) $height=(int)$scale * 60;

                    $space=array('top'=>2*$scale,'bottom'=>2*$scale,'left'=>2*$scale,'right'=>2*$scale);

                    /* count total width */
                    $xpos=0;
                    $width=true;
                    for ($i=0;$i<strlen($bars);$i++){
                      $val=strtolower($bars[$i]);
                      if ($width){
                          $xpos+=$val*$scale;
                          $width=false;
                          continue;
                      }
                      if (preg_match("#[a-z]#", $val)){
                          /* tall bar */
                          $val=ord($val)-ord('a')+1;
                      }
                      $xpos+=$val*$scale;
                      $width=true;
                    }

                    /* allocate the image */
                    $total_x=( $xpos )+$space['right']+$space['right'];
                    $xpos=$space['left'];
                    if (!function_exists("imagecreate")){
                    // return "Please ask your site admin to install php_gd2 extention";
                      return Response::json(['ImageError' => 'Please ask your site admin to install php_gd2 extention']);

                    }
                    $im=imagecreate($total_x, $height);
                    /* create two images */
                    $col_bg=ImageColorAllocate($im,$bg_color[0],$bg_color[1],$bg_color[2]);
                    $col_bar=ImageColorAllocate($im,$bar_color[0],$bar_color[1],$bar_color[2]);
                    $col_text=ImageColorAllocate($im,$text_color[0],$text_color[1],$text_color[2]);
                    $height1=round($height-($scale*10));
                    $height12=round($height-$space['bottom']);
                    /* paint the bars */
                    $width=true;
                    for ($i=0;$i<strlen($bars);$i++){
                      $val=strtolower($bars[$i]);
                      if ($width){
                        $xpos+=$val*$scale;
                        $width=false;
                        continue;
                      }
                      if (preg_match("#[a-z]#", $val)){
                        /* tall bar */
                        $val=ord($val)-ord('a')+1;
                        $h=$height12;
                      } else $h=$height1;
                      imagefilledrectangle($im, $xpos, $space['top'], $xpos+($val*$scale)-1, $h, $col_bar);
                      $xpos+=$val*$scale;
                      $width=true;
                    }
                    global $_SERVER;
                    $chars=explode(" ", $text);
                    reset($chars);
                    foreach($chars as $n => $v) {
                      if (trim($v)){
                          $inf=explode(":", $v);
                          $fontsize=$scale*($inf[1]/1.8);
                          $fontheight1=$height-($fontsize/2.7)+2;
                          @imagettftext($im, $fontsize, 0, $space['left']+($scale*$inf[0])+2,
                          $fontheight1, $col_text, $font, $inf[2]);
                      }
                    }
                    header("Content-Type: image/png; name=\"barcode.png\"");
                    return $im;
                  }


}

