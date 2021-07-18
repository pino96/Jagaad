# Jagaad GIUSEPPE SCALISE

- Magento 2.4.2-p1 ce


- PLUGIN
    <table>
        <tr>
            <td>SCENARIO #1</td>
            <td>PLUGIN A</td>
            <td>PLUGIN B</td>
            <td>PLUGIN C</td>
        </tr>
        <tr>
            <td>Sort Order</td>
            <td>10</td>
            <td>20</td>
            <td>30</td>
        </tr>
        <tr>
            <td>before</td>
            <td>beforeDispatch</td>
            <td>beforeDispatch</td>
            <td></td>
        </tr>
        <tr>
            <td>around</td>
            <td>aroundDispatch</td>
            <td>aroundDispatch</td>
            <td>aroundDispatch</td>
        </tr>
        <tr>
            <td>after</td>
            <td></td>
            <td>afterDispatch</td>
            <td>afterDispatch</td>
        </tr>
    </table>
- SOLUTION <br/>
-- BeforeA <br/>
-- AroundA (until callable method) <br/>
-- BeforeB <br/>
-- AroundB (until callable method) <br/>
-- AroundC (until callable method) <br/>
---- DISPATCH <br/>
-- AroundC (after callable method) <br/>
-- AfterC <br/>
-- AroundB (after callable method) <br/>
-- AfterB <br/>
-- AroundA (after callable method) <br/>

    <table>
        <tr>
            <td>SCENARIO #2</td>
            <td>PLUGIN A</td>
            <td>PLUGIN B</td>
            <td>PLUGIN C</td>
        </tr>
        <tr>
            <td>Sort Order</td>
            <td>10</td>
            <td>20</td>
            <td>30</td>
        </tr>
        <tr>
            <td>before</td>
            <td>beforeDispatch</td>
            <td></td>
            <td>beforeDispatch</td>
        </tr>
        <tr>
            <td>around</td>
            <td></td>
            <td>aroundDispatch</td>
            <td>aroundDispatch</td>
        </tr>
        <tr>
            <td>after</td>
            <td>afterDispatch</td>
            <td>afterDispatch</td>
            <td>afterDispatch</td>
        </tr>
    </table>
- SOLUTION<br/>
-- BeforeA <br/>
-- AroundB (until callable method) <br/>
-- BeforeC <br/>
-- AroundC (until callable method) <br/>
-- DISPATCH <br/>
-- AroundC (after callable method) <br/>
-- AfterC <br/>
-- AroundB (after callable method) <br/>
-- AfterB <br/>
-- AfterA <br/>



- Object Instantiation

<table>
    <tr>
        <td>Class type</td>
        <td>Service or data object?</td>
        <td>We can get an instance using DI, injecting it as a constructor parameter</td>
        <td>We can get an instance using a Factory</td>
        <td>We can get an instance using a Repository</td>
    </tr>
    <tr>
        <td>ScopeConfigInterface</td>
        <td>Service</td>
        <td>True</td>
        <td>False</td>
        <td>False</td>
    </tr>
    <tr>
        <td>ProductRepositoryInterface</td>
        <td>Service</td>
        <td>True</td>
        <td>False</td>
        <td>True</td>
    </tr>
    <tr>
        <td>ProductInterfaceFactory</td>
        <td>Data Object</td>
        <td>True</td>
        <td>True</td>
        <td>False</td>
    </tr>
    <tr>
        <td>ProductInterface</td>
        <td>Data Object</td>
        <td>True</td>
        <td>True</td>
        <td>False</td>
    </tr>
    <tr>
        <td>OrderInterface</td>
        <td>Data Object</td>
        <td>True</td>
        <td>True</td>
        <td>False</td>
    </tr>
</table> 