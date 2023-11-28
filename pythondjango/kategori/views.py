from django.shortcuts import render

# Create your views here.

from rest_framework.parsers import JSONParser
from django.views.decorators.csrf import csrf_exempt
from django.http import HttpResponse, JsonResponse
from .serializers import KategoriSerializer
from .models import Kategori
from utils.helper import json_format

@csrf_exempt
def tasks(request):
    if(request.method == 'GET'):
        tasks = Kategori.objects.all()
        serializer = KategoriSerializer(tasks, many=True)
        reply = json_format(200, 'Fetch all data', serializer.data)

        return JsonResponse(reply, safe=False)
    elif(request.method == 'POST'):
        data = JSONParser().parse(request)
        serializer = KategoriSerializer(data=data)

        if(serializer.is_valid()):
            serializer.save()
            reply = json_format(201, 'Data created', serializer.data)
            return JsonResponse(reply, status=reply['status'])
        
        return JsonResponse(serializer.errors, status=400)
    
@csrf_exempt
def task_detail(request, pk):
    try:
        item = Kategori.objects.get(pk=pk)
    except:
        return HttpResponse(status=404)
    
    if(request.method == 'PUT'):
        data = JSONParser().parse(request)  
        serializer = KategoriSerializer(item, data=data)
        
        if(serializer.is_valid()):  
            serializer.save() 
            reply = json_format(200, 'Data updated', serializer.data)

            return JsonResponse(reply, status=reply['status'])
        
        return JsonResponse(serializer.errors, status=400)
    elif(request.method == 'DELETE'):
        item.delete()
        
        return HttpResponse(status=204)