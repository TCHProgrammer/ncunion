<?php
$this->title = 'Тариф Оптимальный';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="calculator tariff-calculator tariff-optimal" id="calculator">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="heading">
                    <h2>Вклад "Оптимальный"</span></h2>
                    <span>САЙТ РЫБАТЕКСТ ПОМОЖЕТ ДИЗАЙНЕРУ</span>
                </div>
            </div>
        </div>
        <div class="calculator-wrapper">
            <div class="row">
                <div class="form">
                    <form action="#" id="tariffForm" data-tariff="1" data-difference="0.25" data-keyrate="7.5">
                        <div class="col-md-7 col-lg-6">
                            <div class="form-inside">
                                <p class="group-name">Хочу вложить</p>
                                <div class="form-group">
                                    <div class="tariff-group">
                                        <div class="bg-layer"></div>
                                        <input type="text" id="text-price" name="text-price" class="text-price">
                                    </div>
                                    <input id="tariffPrice"
                                           type="text"
                                           name="price"
                                           data-min="50000"
                                           data-max="1499999"
                                           data-from="50000"
                                           data-type="single">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="group">
                                            <p class="group-name">На сколько месяцев</p>

                                            <div class="radio-group radio-group-month flex">
                                                <div class="radio input optimal">
                                                    <input type="radio" id="month-3" name="month" value="3" checked>
                                                    <label for="month-3">
                                                        <span>3</span>
                                                    </label>
                                                </div>
                                                <div class="radio input optimal universal">
                                                    <input type="radio" id="month-12" name="month" value="12">
                                                    <label for="month-12">
                                                        <span>12</span>
                                                    </label>
                                                </div>
                                                <div class="radio input universal">
                                                    <input type="radio" id="month-36" name="month" value="36">
                                                    <label for="month-36">
                                                        <span>36</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="group">
                                            <p class="group-name">Выплата процентов</p>

                                            <div class="radio-group radio-group-pay flex">
                                                <div class="radio">
                                                    <input type="radio" id="percent-payment-1" name="percent-payment" value="1" checked>
                                                    <label for="percent-payment-1">
                                                        <span>ежемесячно</span>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <input type="radio" id="percent-payment-2" name="percent-payment" value="2">
                                                    <label for="percent-payment-2">
                                                        <span>в конце срока</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="checkbox-additional">
                                    <p class="group-name">Дополнительная информация</p>

                                    <div class="checkbox input optimal universal">
                                        <input type="checkbox" id="additional-guarantees-1" name="additional" value="1">
                                        <label for="additional-guarantees-1">
                                            <span class="square"></span>
                                            <span>Страховка</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-6">
                            <div class="form-inside blue" id="tariff-result">

                                <ul class="item-conditions list-unstyled flex">
                                    <li class="item-condition full-price">
                                        <p class="name">По вкладу "Оптимальный"<br>вы получите:</p>
                                        <p class="value">---</p>
                                    </li>
                                    <li class="item-condition item-revenue with-icon">
                                        <p class="name">Доход:</p>
                                        <p class="value">---</p>
                                    </li>
                                    <li class="item-condition item-percent with-icon">
                                        <p class="name">Ставка:</p>
                                        <p class="value">---</p>
                                    </li>
                                    <li class="item-condition item-month with-icon">
                                        <p class="name">Срок вклада:</p>
                                        <p class="value">---</p>
                                    </li>
                                    <li class="item-condition item-revenue-by-month">
                                        <p class="name">Доход в месяц:</p>
                                        <p class="value">---</p>
                                    </li>
                                    <li class="item-condition item-pay">
                                        <p class="name">Выплата:</p>
                                        <p class="value">---</p>
                                    </li>
                                    <li class="item-condition item-before">
                                        <p class="name">Досрочное снятие:</p>
                                        <p class="value">нет</p>
                                    </li>
                                </ul>

                                <div class="buttons">
                                    <a class="btn btn-default btn-consult btn-tariff">Оставить заявку</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>