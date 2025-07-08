@extends('layouts.adminLayout')

@section('content')
<div class="space-y-6 p-6">
    <!-- Portfolio Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total AUM -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-3xl font-bold mt-1">12.8K</p>
                    <p class="text-sm mt-2"><span class="text-green-500 font-medium"><i class="fas fa-caret-up"></i>  4.2%</span> vs last month</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <!--<i class="fas fa-wallet text-blue-500 text-xl"></i>-->
                    <i class="fas fa-users text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Active Clients -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Subscribed Users</p>
                    <p class="text-3xl font-bold mt-1">248</p>
                    <p class="text-sm mt-2"><span class="text-green-500 font-medium"><i class="fas fa-caret-up"></i> 8.3%</span> vs last month</p>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <i class="fas fa-users text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- YTD Performance -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">YTD Performance</p>
                    <p class="text-3xl font-bold mt-1">+9.7%</p>
                    <p class="text-sm mt-2"><span class="text-green-500 font-medium">+1.2%</span> vs benchmark</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Risk Level -->
        <!--<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">-->
        <!--    <div class="flex justify-between items-start">-->
        <!--        <div>-->
        <!--            <p class="text-sm font-medium text-gray-500">Avg. Risk Level</p>-->
        <!--            <p class="text-3xl font-bold mt-1">Moderate</p>-->
        <!--            <p class="text-sm mt-2">Most clients: <span class="font-medium">Balanced</span></p>-->
        <!--        </div>-->
        <!--        <div class="bg-yellow-50 p-3 rounded-lg">-->
        <!--            <i class="fas fa-shield-alt text-yellow-500 text-xl"></i>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    
    <!-- Performance Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Performance</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-lg">1M</button>
                <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg">1Y</button>
                <button class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-lg">3Y</button>
                <button class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-lg">5Y</button>
                <button class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded-lg">All</button>
            </div>
        </div>
        <div class="h-80">
            <canvas id="performanceChart"></canvas>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Portfolio Distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-1">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Loading.......</h3>
            <div class="h-64">
                <canvas id="portfolioChart"></canvas>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Recent Users</h3>
                <button class="text-sm text-blue-600 font-medium">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">John Doe</div>
                                        <div class="text-sm text-gray-500">#CL-1001</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buy</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">AAPL</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$12,450.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Completed</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 min ago</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Jane+Smith&background=random" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Jane Smith</div>
                                        <div class="text-sm text-gray-500">#CL-1042</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Sell</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">TSLA</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$8,720.50</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 min ago</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Robert+Johnson&background=random" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Robert Johnson</div>
                                        <div class="text-sm text-gray-500">#CL-1098</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buy</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">VTI</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$25,000.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Completed</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 hour ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Market Overview -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">Market Overview</h3>
            <button class="text-sm text-blue-600 font-medium">View All Markets</button>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <!-- Market Card 1 -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">S&P 500</p>
                        <p class="text-2xl font-bold mt-1">4,567.89</p>
                    </div>
                    <span class="text-green-500 text-sm font-medium"><i class="fas fa-caret-up"></i> 0.45%</span>
                </div>
            </div>
            <!-- Market Card 2 -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">NASDAQ</p>
                        <p class="text-2xl font-bold mt-1">14,210.34</p>
                    </div>
                    <span class="text-red-500 text-sm font-medium"><i class="fas fa-caret-down"></i> 0.23%</span>
                </div>
            </div>
            <!-- Market Card 3 -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">DJIA</p>
                        <p class="text-2xl font-bold mt-1">35,678.12</p>
                    </div>
                    <span class="text-green-500 text-sm font-medium"><i class="fas fa-caret-up"></i> 0.67%</span>
                </div>
            </div>
            <!-- Market Card 4 -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">BTC/USD</p>
                        <p class="text-2xl font-bold mt-1">$29,456.78</p>
                    </div>
                    <span class="text-green-500 text-sm font-medium"><i class="fas fa-caret-up"></i> 2.34%</span>
                </div>
            </div>
            <!-- Market Card 5 -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">Gold</p>
                        <p class="text-2xl font-bold mt-1">$1,945.67</p>
                    </div>
                    <span class="text-red-500 text-sm font-medium"><i class="fas fa-caret-down"></i> 0.89%</span>
                </div>
            </div>
            <!-- Market Card 6 -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">10Y Bond</p>
                        <p class="text-2xl font-bold mt-1">3.45%</p>
                    </div>
                    <span class="text-red-500 text-sm font-medium"><i class="fas fa-caret-down"></i> 0.12%</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection