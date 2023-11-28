from django.shortcuts import render

# Create your views here.

from rest_framework.parsers import JSONParser
from django.views.decorators.csrf import csrf_exempt
from django.http import HttpResponse, JsonResponse
from .serializers import ProdukSerializer, JoinSerializer
from .models import Produk
from utils.helper import json_format

@csrf_exempt
def tasks(request):
    if(request.method == 'GET'):
        params = request.GET
        print(params)

        rows = Produk.objects.select_related('kategori', 'status').all().order_by('id')

        if('displayWhich' in params):
            if(params['displayWhich'] == '1'):
                rows = rows.filter(status_id=1)
            elif(params['displayWhich'] == '2'):
                rows = rows.filter(status_id=2)
            elif(params['displayWhich'] == '3'):
                rows = rows
            else:
                return HttpResponse(status=400)

        #set nama_kategori and nama_status
        for row in rows:
            row.nama_kategori = row.kategori.nama
            row.nama_status = row.status.nama

        #rows = Produk.objects.all()
        serializer = JoinSerializer(rows, many=True)

        reply = json_format(200, 'Fetch all data', serializer.data)

        return JsonResponse(reply, safe=False)
    elif(request.method == 'POST'):
        data = JSONParser().parse(request)
        serializer = ProdukSerializer(data=data)

        if(serializer.is_valid()):
            serializer.save()
            reply = json_format(201, 'Data created', serializer.data)
            return JsonResponse(reply, status=reply['status'])
        
        return JsonResponse(serializer.errors, status=400)
    
@csrf_exempt
def task_detail(request, pk):
    try:
        item = Produk.objects.get(pk=pk)
    except:
        return HttpResponse(status=404)
    
    if(request.method == 'PUT'):
        data = JSONParser().parse(request)  
        serializer = ProdukSerializer(item, data=data)
        
        if(serializer.is_valid()):
            serializer.save() 
            reply = json_format(200, 'Data updated', serializer.data)

            return JsonResponse(reply, status=reply['status'])
        
        return JsonResponse(serializer.errors, status=400)
    elif(request.method == 'DELETE'):
        item.delete()
        
        return HttpResponse(status=204)